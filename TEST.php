<?php
session_start();
include("main_connection.php");

// Define base_url if not defined in sidebar
$base_url = '/SOLIERA_RESTAURANT'; // Adjust this to your actual base URL

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testing Dashboard</title>
    <?php include 'INCLUDES/header.php'; ?>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Smooth dropdown animations */
        .dropdown-content {
            transition: max-height 0.3s ease-in-out, opacity 0.2s ease-in-out;
        }

        .menu-dropdown:hover .dropdown-content {
            max-height: 400px;
        }

        /* Ensure sidebar content flows naturally */
        .sidebar-expandable {
            transition: all 0.3s ease-in-out;
        }

        /* Smooth scrolling for dropdown content */
        .dropdown-content::-webkit-scrollbar {
            width: 4px;
        }

        .dropdown-content::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
            border-radius: 2px;
        }

        .dropdown-content::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 2px;
        }

        .dropdown-content::-webkit-scrollbar-thumb:hover {
            background: rgba(255,255,255,0.5);
        }

        /* Active state for dropdown items */
        .dropdown-content a.active {
            background: rgba(59, 130, 246, 0.3);
            color: white;
        }

        /* Hover effects for dropdown items */
        .dropdown-content a:hover {
            background: rgba(59, 130, 246, 0.4);
            transform: translateX(2px);
            transition: all 0.2s ease;
        }

        /* Main layout fixes */
        .main-container {
            display: flex;
            min-height: 100vh;
        }
        
        .content-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            margin-left: 0;
        }
        
        @media (min-width: 768px) {
            .content-wrapper {
                margin-left: 16rem; /* 64 * 4 = 256px = 16rem */
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'INCLUDES/sidebar.php'; ?>

        <div class="content-wrapper w-full">
            <!-- Navbar -->
            <?php include 'INCLUDES/navbar.php'; ?>

            <!-- Main Content -->
            <main class="flex-1 p-4 md:p-6">
                <div class="max-w-7xl mx-auto">
                    <!-- Dashboard Header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-gray-900">Testing Dashboard</h2>
                        <p class="text-gray-600 mt-2">Simple dashboard for testing USM components</p>
                    </div>

                    <!-- Dashboard Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        <!-- HR Card -->
                        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-blue-100 mr-4">
                                    <i data-lucide="briefcase" class="w-6 h-6 text-blue-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">HR Management</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Human Resources department management and employee records.</p>
                            <a href="#" class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center">
                                Access HR Module
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>

                        <!-- Logistics Card -->
                        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-green-100 mr-4">
                                    <i data-lucide="truck" class="w-6 h-6 text-green-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Logistics</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Supply chain, inventory management, and distribution tracking.</p>
                            <a href="#" class="text-green-600 hover:text-green-800 font-medium text-sm flex items-center">
                                Access Logistics
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>

                        <!-- Admin Card -->
                        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-purple-100 mr-4">
                                    <i data-lucide="user-cog" class="w-6 h-6 text-purple-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Administration</h3>
                            </div>
                            <p class="text-gray-600 mb-4">System administration, user management, and configuration.</p>
                            <a href="#" class="text-purple-600 hover:text-purple-800 font-medium text-sm flex items-center">
                                Access Admin Panel
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>

                        <!-- Hotel Transactions Card -->
                        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-amber-100 mr-4">
                                    <i data-lucide="building" class="w-6 h-6 text-amber-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Hotel Transactions</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Hotel booking, room management, and guest services.</p>
                            <a href="#" class="text-amber-600 hover:text-amber-800 font-medium text-sm flex items-center">
                                View Hotel Transactions
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>

                        <!-- Restaurant Transactions Card -->
                        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-red-100 mr-4">
                                    <i data-lucide="utensils" class="w-6 h-6 text-red-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Restaurant Transactions</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Dining orders, table reservations, and food service management.</p>
                            <a href="#" class="text-red-600 hover:text-red-800 font-medium text-sm flex items-center">
                                View Restaurant Transactions
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>

                        <!-- Financials Card -->
                        <div class="bg-white rounded-xl shadow-md p-6 border border-gray-200 hover:shadow-lg transition-shadow">
                            <div class="flex items-center mb-4">
                                <div class="p-3 rounded-lg bg-emerald-100 mr-4">
                                    <i data-lucide="dollar-sign" class="w-6 h-6 text-emerald-600"></i>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900">Financials</h3>
                            </div>
                            <p class="text-gray-600 mb-4">Financial reports, accounting, and revenue management.</p>
                            <a href="#" class="text-emerald-600 hover:text-emerald-800 font-medium text-sm flex items-center">
                                Access Financial Reports
                                <i data-lucide="arrow-right" class="w-4 h-4 ml-2"></i>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Stats Section -->
                    <div class="mt-8 bg-white rounded-xl shadow-md p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Statistics</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-blue-600 font-medium">Active Users</p>
                                <p class="text-2xl font-bold text-gray-900">142</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-green-600 font-medium">Today's Transactions</p>
                                <p class="text-2xl font-bold text-gray-900">87</p>
                            </div>
                            <div class="bg-purple-50 p-4 rounded-lg">
                                <p class="text-sm text-purple-600 font-medium">Pending Approvals</p>
                                <p class="text-2xl font-bold text-gray-900">12</p>
                            </div>
                            <div class="bg-amber-50 p-4 rounded-lg">
                                <p class="text-sm text-amber-600 font-medium">System Uptime</p>
                                <p class="text-2xl font-bold text-gray-900">99.8%</p>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();

        // Handle dropdown hover states
        const dropdowns = document.querySelectorAll('.menu-dropdown');
        
        if (dropdowns.length > 0) {
            dropdowns.forEach(dropdown => {
                dropdown.addEventListener('mouseenter', function() {
                    const content = this.querySelector('.dropdown-content');
                    if (content) {
                        content.style.maxHeight = content.scrollHeight + 'px';
                    }
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    const content = this.querySelector('.dropdown-content');
                    if (content) {
                        content.style.maxHeight = '0';
                    }
                });
            });

            // Add click functionality for mobile
            if (window.innerWidth < 768) {
                dropdowns.forEach(dropdown => {
                    const button = dropdown.querySelector('button');
                    if (button) {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            const content = this.parentElement.querySelector('.dropdown-content');
                            const isOpen = content && content.style.maxHeight && content.style.maxHeight !== '0px';
                            
                            // Close all other dropdowns
                            dropdowns.forEach(otherDropdown => {
                                if (otherDropdown !== dropdown) {
                                    const otherContent = otherDropdown.querySelector('.dropdown-content');
                                    if (otherContent) {
                                        otherContent.style.maxHeight = '0';
                                    }
                                }
                            });
                            
                            // Toggle current dropdown
                            if (content) {
                                if (isOpen) {
                                    content.style.maxHeight = '0';
                                } else {
                                    content.style.maxHeight = content.scrollHeight + 'px';
                                }
                            }
                        });
                    }
                });
            }
        }

        // Logout button functionality
        // Note: You might want to add a logout button in the top nav instead
        // document.querySelector('button[type="button"]').addEventListener('click', function() {
        //     if (confirm('Are you sure you want to logout?')) {
        //         alert('Logged out successfully!');
        //     }
        // });
    </script>
</body>
</html>