@extends('layouts.app')
@section('content')
    <div class="title-box">
        <h2></h2>
        <p></p>
    </div>
    <div class="title">
        <h2>Task Management</h2>
        <button type="button" class="open-modal-btn">Create</button>
    </div>
    <form id="searchForm" class="search-table">
        <fieldset>
            <label for="">Name</label>
            <input type="text" id="name" placeholder="Name" class="mb-0" />
        </fieldset>
        <fieldset>
            <label for="">Status</label>
            <select  name="status" id="status" class="mb-0 bg-white">
                <option value="">Choose</option>
                <option value="1">todo</option>
                <option value="2">in-progress</option>
                <option value="3">done</option>
            </select>
        </fieldset>
        <button type="submit">Search</button>
    </form>
    <div class="table-responsive">
        <table id="table-design">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <div class="modal-title">
                <h2>Add Task</h2>
                <span class="close">×</span>
            </div>
            <div id="modal-errors"></div>
            <form id="modalForm">
                <input type="text" id="modal-name" placeholder="Text"/>
                <textarea id="modal-description" rows="5" placeholder="Content"></textarea>
                <select id="modal-select">
                    <option value="">Choose</option>
                    <option value="1">todo</option>
                    <option value="2">in-progress</option>
                    <option value="3">done</option>
                </select>
                <button type="submit">Send</button>
            </form>
        </div>
    </div>
@endsection

@section('css')
@endsection

@section('js')

<script>
    // Utility function to get element by ID
    const getById = id => document.getElementById(id);

    // Utility function to set inner HTML of an element
    const setInnerHTML = (id, html) => getById(id).innerHTML = html;

    // Utility function to fetch JSON data
    const fetchJson = (url, options) => fetch(url, options).then(response => response.json());

    const currentUrl = new URL(window.location.href);
    const projectId = currentUrl.pathname.split('/').pop();

    const modal = getById('myModal');
    const closeModalBtn = modal.querySelector('.close');
    const openModalBtn = document.querySelector('.open-modal-btn');
    const form = getById('modalForm');
    const searchForm = getById('searchForm');
    let currentItemId = null;

    // Open modal with specific details
    function openModal(title, name = '', description = '', status = '', id = null) {
        modal.querySelector('.modal-title h2').textContent = title;
        getById('modal-name').value = name;
        getById('modal-description').value = description;
        getById('modal-select').value = status;
        setInnerHTML('modal-errors', '');
        currentItemId = id;
        modal.style.display = 'block';
    }

    // Open modal for adding a new task
    openModalBtn.onclick = () => openModal('Add Task');

    // Close modal
    closeModalBtn.onclick = () => modal.style.display = 'none';
    window.onclick = event => {
        if (event.target == modal) modal.style.display = 'none';
    };

    const apiUrl = '/api';

    // Handle form submission
    form.onsubmit = event => {
        event.preventDefault();
        const name = getById('modal-name').value;
        const description = getById('modal-description').value;
        const status = getById('modal-select').value;
        const method = currentItemId ? 'PUT' : 'POST';
        const url = currentItemId ? `${apiUrl}/task/${currentItemId}` : `${apiUrl}/task`;
        const body = JSON.stringify({ 'project_id':projectId, name, description, status });

        fetchJson(url, { method, headers: { 'Content-Type': 'application/json' }, body })
            .then(data => {
                if (data.errors) {
                    const errorsHtml = Object.values(data.errors).map(err => `<p>${err.join(', ')}</p>`).join('');
                    setInnerHTML('modal-errors', errorsHtml);
                } else {
                    modal.style.display = 'none';
                    fetchData();
                }
            })
            .catch(error => console.error(`${method === 'POST' ? 'Create' : 'Update'} task error:`, error));
    };

    // Handle search form submission
    searchForm.onsubmit = event => {
        event.preventDefault();
        const name = getById('name').value;
        const status = getById('status').value;
        const url = `${apiUrl}/task/search?name=${encodeURIComponent(name)}&status=${status}&project_id=${projectId}`;

        fetchJson(url)
            .then(data => fetchDataTable(data.data))
            .catch(error => console.error('Search error:', error));
    };

    // Create a new task
    const create = (name, description, status) => {
        fetchJson(`${apiUrl}/task`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ 'project_id':projectId, name, description, status })
        }).then(data => {
            if (data.errors) {
                const errorsHtml = Object.values(data.errors).map(err => `<p>${err.join(', ')}</p>`).join('');
                setInnerHTML('modal-errors', errorsHtml);
            } else {
                modal.style.display = 'none';
                fetchData();
            }
        }).catch(error => console.error('Error creating task:', error));
    };

    // Update an existing task
    const update = (name, description, status) => {
        fetchJson(`${apiUrl}/task/${currentItemId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({'project_id':projectId, name, description, status })
        }).then(data => {
            if (data.errors) {
                const errorsHtml = Object.values(data.errors).map(err => `<p>${err.join(', ')}</p>`).join('');
                setInnerHTML('modal-errors', errorsHtml);
            } else {
                modal.style.display = 'none';
                fetchData();
            }
        }).catch(error => console.error('Error updating task:', error));
    };

    // Fetch project data and update UI
    const fetchData = () => {
        fetchJson(`${apiUrl}/project/${projectId}`)
            .then(data => {
                const { name, description, task } = data.data;
                const titleBox = document.querySelector('.title-box');
                if (name) titleBox.querySelector('h2').textContent = name;
                if (description) titleBox.querySelector('p').textContent = description;
                fetchDataTable(task);
            })
            .catch(error => console.error('Error fetching project data:', error));
    };

    // Populate table with data
    const fetchDataTable = data => {
        const tableBody = document.querySelector('#table-design tbody');
        tableBody.innerHTML = '';

        data.forEach(item => {
            const row = document.createElement('tr');

            const nameCell = document.createElement('td');
            nameCell.textContent = item.name;
            row.appendChild(nameCell);

            const descCell = document.createElement('td');
            descCell.textContent = item.description;
            row.appendChild(descCell);

            const statusCell = document.createElement('td');
            let status='';
            if(item.status===1)
                status='TODO'
            else if(item.status===2)
                status='IN_PROGRESS'
            else
                status='DONE'
            statusCell.textContent = status;
            row.appendChild(statusCell);

            const actionCell = document.createElement('td');
            const actionButtonsDiv = document.createElement('div');
            actionButtonsDiv.className = 'action-buttons';

            const editButton = document.createElement('button');
            editButton.textContent = 'Edit';
            editButton.onclick = () => openModal('Edit Task', item.name, item.description, item.status, item.id);
            actionButtonsDiv.appendChild(editButton);

            const deleteButton = document.createElement('button');
            deleteButton.textContent = 'Delete';
            deleteButton.onclick = () => {
                if (confirm('Are you sure you want to delete this item?')) {
                    fetch(`${apiUrl}/task/${item.id}`, { method: 'DELETE' })
                        .then(response => {
                            if (response.ok) row.remove();
                            else alert('Failed to delete item.');
                        })
                        .catch(error => console.error('Error deleting item:', error));
                }
            };
            actionButtonsDiv.appendChild(deleteButton);

            actionCell.appendChild(actionButtonsDiv);
            row.appendChild(actionCell);

            tableBody.appendChild(row);
        });
    };

    // Initial data fetch on page load
    window.onload = fetchData;
</script>

@endsection
