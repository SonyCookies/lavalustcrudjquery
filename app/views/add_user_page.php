<?php
defined('PREVENT_DIRECT_ACCESS') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
</head>
<body class="bg-gray-100 min-h-screen">
    <header class="bg-primary text-white shadow-lg py-6 px-8">
        <div class="container mx-auto">
            <h1 class="text-3xl font-bold">Add New User</h1>
        </div>
    </header>

    <main class="container mx-auto px-8 py-12">
        <div class="bg-white shadow-2xl rounded-2xl p-10 max-w-2xl mx-auto">
            <form id="addUserForm" class="space-y-8">
                <div>
                    <label for="sps_last_name" class="block text-lg font-medium text-gray-700 mb-2">Last Name</label>
                    <input type="text" id="sps_last_name" name="sps_last_name" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="sps_first_name" class="block text-lg font-medium text-gray-700 mb-2">First Name</label>
                    <input type="text" id="sps_first_name" name="sps_first_name" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="sps_email" class="block text-lg font-medium text-gray-700 mb-2">Email</label>
                    <input type="email" id="sps_email" name="sps_email" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition duration-150 ease-in-out">
                </div>

                <div>
                    <label for="sps_gender" class="block text-lg font-medium text-gray-700 mb-2">Gender</label>
                    <select id="sps_gender" name="sps_gender" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition duration-150 ease-in-out">
                        <option value="">Select Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                        <option value="Other">Other</option>
                    </select>
                </div>

                <div>
                    <label for="sps_address" class="block text-lg font-medium text-gray-700 mb-2">Address</label>
                    <textarea id="sps_address" name="sps_address" rows="4" required class="w-full px-4 py-3 rounded-lg border-2 border-gray-300 focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 transition duration-150 ease-in-out"></textarea>
                </div>

                <div class="flex justify-between pt-6">
                    <button type="submit" class="px-8 py-4 bg-secondary text-white text-lg font-semibold rounded-lg shadow-md hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-75 transition duration-150 ease-in-out">
                        Add User
                    </button>
                    <a href="/users" class="px-8 py-4 bg-gray-200 text-gray-700 text-lg font-semibold rounded-lg shadow-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75 transition duration-150 ease-in-out">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </main>

    <footer class="bg-gray-800 text-white py-8 mt-12">
        <div class="container mx-auto text-center">
            <p>&copy; 2024 Add User. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#addUserForm').on('submit', function(e) {
            e.preventDefault(); 

            var formData = {
                sps_last_name: $('#sps_last_name').val(),
                sps_first_name: $('#sps_first_name').val(),
                sps_email: $('#sps_email').val(),
                sps_gender: $('#sps_gender').val(),
                sps_address: $('#sps_address').val()
            };

            $.ajax({
                url: '/user/create',
                type: 'POST', 
                data: formData,
                success: function(response) {
                    // alert('User added successfully!');
                    window.location.href = '/users'; 
                },
                error: function(xhr, status, error) {
                    alert('An error occurred: ' + error);
                }
            });
        });
    });
    </script>
</body>