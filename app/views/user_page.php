<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Users Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script type="text/javascript" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: '#4F46E5',
            secondary: '#10B981',
          }
        }
      }
    }
  </script>
  <style>
    .dataTables_wrapper {
      background: white;
      border-radius: 1rem;
      box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);
      padding: 2rem;
    }

    .dataTables_filter input {
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      border: 2px solid #e2e8f0;
    }

    .dataTables_length select {
      padding: 0.5rem 2rem 0.5rem 1rem;
      border-radius: 0.5rem;
      border: 2px solid #e2e8f0;
    }

    .dataTables_paginate .paginate_button {
      padding: 0.5rem 1rem;
      border-radius: 0.5rem;
      margin: 0 0.25rem;
    }

    .dataTables_paginate .paginate_button.current {
      background-color: #4F46E5;
      color: white !important;
    }
  </style>
</head>

<body class="bg-gray-100 min-h-screen">
  <!-- Header -->
  <header class="bg-primary text-white shadow-lg py-6 px-8">
    <div class="container mx-auto flex justify-between items-center">
      <h1 class="text-3xl font-bold">Users Dashboard</h1>
      <button class="bg-secondary hover:bg-green-600 text-white px-6 py-3 rounded-lg shadow-md transition-colors text-lg font-semibold">
        <a href="/user/create" class="flex items-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
          </svg>
          Add User
        </a>
      </button>
    </div>
  </header>

  <!-- Main Content -->
  <main class="container mx-auto px-8 py-12">
    <div class="bg-white shadow-2xl rounded-2xl p-10">
      <div class="flex justify-between items-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Users List</h2>
        <div class="text-sm text-gray-500">Updated just now</div>
      </div>
      <table id="userTable" class="w-full">
        <thead>
          <tr class="text-left text-gray-600 text-lg">
            <th class="px-6 py-4 font-semibold">First Name</th>
            <th class="px-6 py-4 font-semibold">Last Name</th>
            <th class="px-6 py-4 font-semibold">Email</th>
            <th class="px-6 py-4 font-semibold">Gender</th>
            <th class="px-6 py-4 font-semibold">Address</th>
            <th class="px-6 py-4 font-semibold">Action</th>
          </tr>
        </thead>
        <tbody class="text-gray-700">
          <!-- Rows populated via AJAX -->
        </tbody>
      </table>
    </div>
  </main>

  <!-- Delete Modal -->
  <div id="deleteModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-2xl shadow-xl p-8 max-w-md w-full mx-4">
      <h3 class="text-2xl font-bold text-gray-800 mb-4">Confirm Delete</h3>
      <p class="text-gray-600 mb-8 text-lg">Are you sure you want to delete this user? This action cannot be undone.</p>
      <div class="flex justify-end gap-4">
        <button onclick="closeModal()" class="px-6 py-3 text-lg font-semibold text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors">
          Cancel
        </button>
        <button id="confirmDeleteBtn" class="px-6 py-3 text-lg font-semibold text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
          Delete
        </button>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function() {
      const dataTable = $('#userTable').DataTable({
        dom: '<"flex flex-col md:flex-row justify-between items-center mb-6"f<"flex items-center gap-4"l<"text-gray-500"i>>>rt<"flex flex-col md:flex-row justify-between items-center mt-6"p>',
        language: {
          search: "",
          searchPlaceholder: "Search users...",
          lengthMenu: "Show _MENU_",
        },
        pageLength: 10,
        columnDefs: [{
          targets: -1,
          orderable: false,
          render: function(data, type, row) {
            return `
                            <div class="flex gap-4">
                                <a href="/user/edit/${row[5]}" class="text-primary hover:text-indigo-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                    </svg>
                                </a>
                                <button onclick="openModal('${row[5]}')" class="text-red-500 hover:text-red-700 transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                        `;
          }
        }]
      });

      function fetchUsers() {
        $.ajax({
          url: '/user/get_all',
          type: 'GET',
          dataType: 'json',
          success: function(data) {
            dataTable.clear();
            if (data.users && data.users.length > 0) {
              data.users.forEach(user => {
                dataTable.row.add([
                  user.sps_first_name,
                  user.sps_last_name,
                  user.sps_email,
                  user.sps_gender,
                  user.sps_address,
                  user.id
                ]);
              });
            } else {
              dataTable.row.add(['No users found', '', '', '', '', '']);
            }
            dataTable.draw();
          },
          error: function() {
            alert('Failed to fetch users.');
          }
        });
      }

      fetchUsers();

      let userIdToDelete = null;

      window.openModal = function(userId) {
        userIdToDelete = userId;
        $('#deleteModal').removeClass('hidden');
      };

      window.closeModal = function() {
        $('#deleteModal').addClass('hidden');
        userIdToDelete = null;
      };

      $('#confirmDeleteBtn').click(function() {
        if (userIdToDelete) {
          $.ajax({
            url: '/user/delete/' + userIdToDelete,
            type: 'GET',
            success: function() {
              closeModal();
              fetchUsers();
            },
            error: function() {
              alert('Failed to delete user.');
            }
          });
        }
      });
    });
  </script>