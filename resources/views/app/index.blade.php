@extends('layouts.app')
@section('content')
    <div class="title">
        <h2>Project List</h2>
        <button class="open-modal-btn">Create</button>
    </div>
    <form id="searchForm" class="search-table">
        <fieldset>
            <label for="">Name</label>
            <input type="text" id="name" placeholder="Name" class="mb-0"/>
        </fieldset>
        <button type="submit">Search</button>
    </form>
        <div class="table-responsive">
            <table id="table-design">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
        <div class="pagination" id="pagination">
            <ul></ul>
        </div>

        <div id="myModal" class="modal">
            <div class="modal-content">
                <div class="modal-title">
                    <h2>Add Project</h2>
                    <span class="close">×</span>
                </div>
                <div id="modal-errors"></div>
                <form id="modalForm">
                    <input type="text" id="modal-name" placeholder="Text"/>
                    <textarea id="modal-description" rows="5" placeholder="Content"></textarea>
                    <button type="submit">Send</button>
                </form>
            </div>
        </div>
@endsection

@section('js')

<script>
    const modal = document.getElementById('myModal');
    const closeModalBtn = modal.querySelector('.close');
    const openModalBtn = document.querySelector('.open-modal-btn');
    const form = document.getElementById('modalForm');
    const searchForm = document.getElementById('searchForm');
    let currentItemId = null;
    const apiUrl = '/api/v1/project';

    // Open modal function for editing or adding projects
    const openModal = (title, name = '', description = '', id = null) => {
        modal.querySelector('.modal-title h2').textContent = title;
        document.getElementById('modal-name').value = name;
        document.getElementById('modal-description').value = description;
        document.getElementById('modal-errors').innerHTML = '';
        currentItemId = id;
        modal.style.display = 'block';
    };

    openModalBtn.onclick = () => openModal("Add Project");

    closeModalBtn.onclick = () => (modal.style.display = 'none');

    window.onclick = (event) => {
        if (event.target === modal) modal.style.display = 'none';
    };

    // Form submission handlers
    form.onsubmit = (event) => {
        event.preventDefault();
        const name = document.getElementById('modal-name').value;
        const description = document.getElementById('modal-description').value;
        currentItemId ? updateProject(name, description) : createProject(name, description);
    };

    searchForm.onsubmit = (event) => {
        event.preventDefault();
        const name = document.getElementById('name').value;
        fetch(`${apiUrl}/search?name=${encodeURIComponent(name)}`, {
            method: 'GET',
            headers: { 'Content-Type': 'application/json' }
        })
            .then(response => response.json())
            .then(data => fetchDataTable(data))
            .catch(error => console.error('Error:', error));
    };

    // CRUD operations
    const createProject = (name, description) => {
        fetch(apiUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, description })
        })
            .then(response => response.json())
            .then(data => handleResponse(data))
            .catch(error => console.error('Error creating project:', error));
    };

    const updateProject = (name, description) => {
        fetch(`${apiUrl}/${currentItemId}`, {
            method: 'PUT',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name, description })
        })
            .then(response => response.json())
            .then(data => handleResponse(data))
            .catch(error => console.error('Error updating project:', error));
    };

    const deleteProject = (id, row) => {
        if (!confirm('Are you sure you want to delete this item?')) return;

        fetch(`${apiUrl}/${id}`, { method: 'DELETE' })
            .then(response => {
                if (response.ok) row.remove();
                else alert('Failed to delete item.');
            })
            .catch(error => console.error('Error deleting project:', error));
    };

    const handleResponse = (data) => {
        if (data.errors) {
            const errorsHtml = Object.values(data.errors).map(err => `<p>${err.join(', ')}</p>`).join('');
            document.getElementById('modal-errors').innerHTML = errorsHtml;
        } else {
            modal.style.display = 'none';
            fetchData();
        }
    };

    // Fetch data and update table
    const fetchData = (page = 1) => {
        fetch(`${apiUrl}?page=${page}`)
            .then(response => response.json())
            .then(data => fetchDataTable(data))
            .catch(error => console.error('Error fetching data:', error));
    };

    const fetchDataTable = (data) => {
        const tableBody = document.querySelector('#table-design tbody');
        const paginationList = document.querySelector('#pagination ul');
        tableBody.innerHTML = '';
        data.data?.data?.forEach(item => {
            const row = createTableRow(item);
            tableBody.appendChild(row);
        });
        updatePagination(data.data?.links);
    };

    const createTableRow = (item) => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${item.name}</td>
            <td>${item.description}</td>
            <td>
                <div class="action-buttons">
                    <button onclick="openModal('Edit Project', '${item.name}', '${item.description}', ${item.id})">Edit</button>
                    <a href="/detail/${item.id}">View</a>
                    <button onclick="deleteProject(${item.id}, this.closest('tr'))">Delete</button>
                </div>
            </td>
        `;
        return row;
    };

    const updatePagination = (links) => {
        const paginationList = document.querySelector('#pagination ul');
        paginationList.innerHTML = '';
        links.forEach(link => {
            const listItem = document.createElement('li');
            listItem.className = 'page';
            if (link.active) listItem.classList.add('active');
            const anchor = document.createElement('a');
            anchor.href = link.url || '#';
            anchor.innerHTML = link.label;
            if (!link.active) {
                anchor.onclick = (e) => {
                    e.preventDefault();
                    const page = new URL(link.url).searchParams.get('page');
                    fetchData(page);
                };
            }
            listItem.appendChild(anchor);
            paginationList.appendChild(listItem);
        });
    };

    // Fetch initial data on page load
    window.onload = fetchData;
</script>

@endsection

@section('css')

@endsection











