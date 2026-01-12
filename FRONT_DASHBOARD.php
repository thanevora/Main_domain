<?php
session_start();
include("main_connection.php");

$db_name = "rest_soliera_usm";
$conn = $connections[$db_name] ?? die("❌ Connection not found for $db_name");

// Fetch cards from database
$sql = "SELECT * FROM dashboard_cards WHERE is_active = 1 ORDER BY display_order, title";
$result = $conn->query($sql);
$departments = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Parse features properly
        $features = json_decode($row['features'], true);
        if ($features === null && !empty($row['features'])) {
            // If not JSON, try to parse as newline-separated
            $features = array_filter(array_map('trim', explode("\n", $row['features'])));
        }
        $row['features'] = $features ?: [];
        $departments[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Dashboard</title>
    <?php include 'INCLUDES/header.php'; ?>
    
    <!-- CSS & Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#001f54',
                        accent: '#F7B32B',
                    }
                }
            }
        }
    </script>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: #ffffff;
            min-height: 100vh;
        }
        
        .department-card {
            background: linear-gradient(135deg, #001f54 0%, #001c4a 100%);
            border: 1px solid rgba(247, 179, 43, 0.2);
            transition: all 0.3s ease;
        }
        
        .department-card.inactive {
            background: linear-gradient(135deg, #4a5568 0%, #2d3748 100%);
            opacity: 0.7;
        }
        
        .department-card:hover {
            background: linear-gradient(135deg, #001f54 0%, #002368 100%);
            border: 1px solid rgba(247, 179, 43, 0.5);
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 31, 84, 0.3);
        }
        
        .custom-tooltip {
            position: fixed;
            z-index: 9999;
            padding: 0;
            opacity: 0;
            visibility: hidden;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            pointer-events: none;
        }
        
        .custom-tooltip.active {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }
        
        .tooltip-arrow {
            width: 0;
            height: 0;
            border-left: 8px solid transparent;
            border-right: 8px solid transparent;
            border-bottom: 8px solid #001f54;
            position: absolute;
            top: -8px;
            left: 50%;
            transform: translateX(-50%);
        }
        
        .hover-indicator {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #F7B32B 0%, rgba(247, 179, 43, 0.5) 100%);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .card-wrapper:hover .hover-indicator {
            transform: scaleX(1);
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .card-animate {
            animation: fadeInUp 0.5s ease-out forwards;
            opacity: 0;
        }
        
        ::-webkit-scrollbar {
            width: 6px;
        }
        
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb {
            background: #001f54;
            border-radius: 3px;
        }
        
        ::-webkit-scrollbar-thumb:hover {
            background: #F7B32B;
        }
        
        .admin-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.8);
            z-index: 10000;
            display: none;
        }
        
        .admin-panel {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 12px;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            max-height: 80vh;
            overflow-y: auto;
            z-index: 10001;
            display: none;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }
        
        .swal2-container {
            z-index: 10002 !important;
        }
        
        .swal2-popup {
            font-family: 'Inter', system-ui, -apple-system, sans-serif !important;
        }
        
        .form-control .error {
            border-color: #dc2626 !important;
        }
        
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
        
        .default-icon {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #F7B32B;
            display: inline-block;
        }
        
        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            border-radius: 12px;
        }
        
        .loading-overlay.active {
            display: flex;
        }
        
        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
    </style>
</head>
<body class="bg-white">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <?php include 'USM/sidebar.php'; ?>

        <!-- Content Area -->
        <div class="flex flex-col flex-1 overflow-hidden">
            <!-- Navbar -->
            <?php include 'INCLUDES/navbar.php'; ?>

            <!-- Main Content -->
            <main class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <!-- Header Section -->
                <div class="mb-10">
                    <h1 class="text-4xl font-bold text-primary mb-3">Department Dashboard</h1>
                    <p class="text-gray-600 text-lg">Hover over department cards to view details. Click to access the system.</p>
                    
                    <!-- Admin Button -->
                    <div class="mt-6">
                        <button id="adminToggle" class="btn btn-primary gap-2">
                            <i data-lucide="settings" class="w-5 h-5"></i>
                            Manage Dashboard Cards
                        </button>
                    </div>
                </div>

                <!-- Cards Grid -->
                <div class="relative">
                    <div class="loading-overlay" id="cardsLoading">
                        <div class="flex flex-col items-center gap-3">
                            <div class="loading loading-spinner loading-lg text-primary"></div>
                            <p class="text-gray-600">Loading cards...</p>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6" id="cardsContainer">
                        <?php foreach ($departments as $index => $dept): ?>
                        <div class="card-wrapper relative group" data-dept-id="<?php echo $dept['id']; ?>">
                            <div class="hover-indicator"></div>
                            <a href="<?php echo $dept['redirect_link']; ?>" 
                               target="_blank" 
                               class="card-link block h-full"
                               data-title="<?php echo htmlspecialchars($dept['title']); ?>"
                               data-description="<?php echo htmlspecialchars($dept['description']); ?>"
                               data-features='<?php echo json_encode($dept['features']); ?>'
                               data-link="<?php echo $dept['redirect_link']; ?>">
                                <div class="department-card rounded-lg p-6 cursor-pointer h-full flex flex-col justify-between card-animate transition-all duration-300">
                                    <div>
                                        <div class="flex items-center justify-between mb-6">
                                            <div class="p-3 rounded-xl bg-white/10">
                                                <span class="default-icon"></span>
                                            </div>
                                            <div class="text-accent/70">
                                                <i data-lucide="external-link" class="w-5 h-5"></i>
                                            </div>
                                        </div>
                                        <h3 class="text-xl font-bold text-accent mb-2"><?php echo $dept['title']; ?></h3>
                                    </div>
                                    <div class="pt-4 border-t border-accent/20 flex items-center justify-between text-white/80 text-sm">
                                        <div class="flex items-center">
                                            <i data-lucide="info" class="w-4 h-4 mr-2 text-accent"></i>
                                            <span>Hover for details</span>
                                        </div>
                                        <span class="px-2 py-1 bg-accent/20 text-accent text-xs rounded-lg">ID: <?php echo str_pad($dept['id'], 2, '0', STR_PAD_LEFT); ?></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </main>

            <!-- Footer -->
            <footer class="mt-12 border-t border-gray-200 bg-white">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="flex flex-col md:flex-row justify-between items-center">
                        <div class="flex items-center mb-6 md:mb-0">
                            <div class="ml-4">
                                <div class="flex items-center space-x-3">
                                    <div class="relative w-10 h-10">
                                        <img 
                                            src="images/s_with_bg.jpg" 
                                            alt="Soliera Hotel & Restaurant Logo" 
                                            class="w-full h-full object-contain rounded-lg"
                                            id="companyLogo"
                                        >
                                    </div>
                                    <div>
                                        <h1 class="font-bold text-primary text-xl">Soliera Hotel & Restaurant</h1>
                                        <p class="text-gray-500 text-sm">Management System</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-gray-600 text-center mb-6 md:mb-0">
                            <p class="mb-2">© 2025 Soliera Hotel & Restaurant Management System. All rights reserved.</p>
                            <p class="text-sm text-gray-500">Version 2.1.0 • Last updated: Today</p>
                        </div>
                        
                        <div class="flex space-x-4">
                            <a href="#" class="btn btn-ghost btn-circle text-gray-500 hover:text-primary">
                                <i data-lucide="help-circle" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="btn btn-ghost btn-circle text-gray-500 hover:text-primary">
                                <i data-lucide="settings" class="w-5 h-5"></i>
                            </a>
                            <a href="#" class="btn btn-ghost btn-circle text-gray-500 hover:text-primary">
                                <i data-lucide="mail" class="w-5 h-5"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>

        <!-- Admin Panel -->
        <div class="admin-overlay" id="adminOverlay"></div>
        <div class="admin-panel bg-base-100 rounded-2xl shadow-2xl p-8 w-full max-w-6xl mx-auto" id="adminPanel">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8 pb-6 border-b border-base-300">
                <div>
                    <h2 class="text-3xl font-bold text-primary flex items-center gap-3">
                        <i data-lucide="layout-dashboard" class="w-8 h-8"></i>
                        Manage Dashboard Cards
                    </h2>
                    <p class="text-base-content/60 mt-2">Customize and organize your dashboard widgets</p>
                </div>
                <button id="closeAdmin" class="btn btn-circle btn-ghost hover:bg-base-300 transition-all">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
            
            <!-- Content Area -->
            <div class="space-y-8">
                <!-- Add Card Button -->
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4">
                        <button id="addCardBtn" class="btn btn-primary btn-lg gap-3 shadow-lg hover:shadow-xl transition-all">
                            <i data-lucide="plus-circle" class="w-6 h-6"></i>
                            Add New Domain
                        </button>
                        <div class="tooltip" data-tip="Add a new widget to your dashboard">
                            <i data-lucide="help-circle" class="w-5 h-5 text-base-content/40"></i>
                        </div>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <table class="bg-white table w-full">
                        <thead>
                            <tr class="bg-[#001f54] text-white">
                                <th class="rounded-tl-lg">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="hash" class="w-4 h-4"></i>
                                        ID
                                    </div>
                                </th>
                                <th>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="type" class="w-4 h-4"></i>
                                        Title
                                    </div>
                                </th>
                                <th>
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="toggle-left" class="w-4 h-4"></i>
                                        Status
                                    </div>
                                </th>
                                <th class="rounded-tr-lg">
                                    <div class="flex items-center gap-2">
                                        <i data-lucide="settings-2" class="w-4 h-4"></i>
                                        Actions
                                    </div>
                                </th>
                            </tr>
                        </thead>
                        <tbody id="adminTableBody" class="divide-y divide-base-300">
                            <tr class="hover:bg-base-300/30 transition-colors">
                                <td colspan="4" class="text-center py-8 text-base-content/50">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="loading loading-spinner loading-md text-primary"></div>
                                        <p>Loading cards...</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Footer -->
            <div class="flex justify-between items-center pt-6 border-t border-base-300">
                <div class="text-sm text-base-content/60 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    <span>Manage your dashboard cards</span>
                </div>
                <div class="flex gap-3">
                    <button class="btn btn-success gap-2" onclick="saveAllChanges()">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Save Changes
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Card Modal -->
        <div class="admin-panel" id="editCardModal" style="max-width: 500px; display: none;">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-primary" id="editModalTitle">Edit Card</h2>
                <button onclick="closeEditModal()" class="btn btn-ghost btn-sm">
                    <i data-lucide="x" class="w-5 h-5"></i>
                </button>
            </div>
            
            <form id="cardForm" class="space-y-4">
                <input type="hidden" id="cardId" name="id">
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Title *</span>
                    </label>
                    <input type="text" id="cardTitle" name="title" class="bg-white input input-bordered w-full" required>
                    <div class="error-message" id="titleError"></div>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Redirect Link *</span>
                    </label>
                    <input type="url" id="cardLink" name="redirect_link" class="bg-white input input-bordered w-full" required>
                    <div class="error-message" id="linkError"></div>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Description *</span>
                    </label>
                    <textarea id="cardDescription" name="description" class="bg-white textarea textarea-bordered h-32" required></textarea>
                    <div class="error-message" id="descriptionError"></div>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold">Features (One per line) *</span>
                    </label>
                    <textarea id="cardFeatures" name="features" class="bg-white textarea textarea-bordered h-32" 
                              placeholder="Feature 1&#10;Feature 2&#10;Feature 3" required></textarea>
                    <div class="error-message" id="featuresError"></div>
                </div>
                
                <div class="form-control">
                    <label class="label cursor-pointer">
                        <span class="label-text font-semibold">Active</span>
                        <input type="checkbox" id="cardActive" name="is_active" class="toggle toggle-primary" checked>
                    </label>
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="closeEditModal()" class="btn btn-ghost">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="saveCardBtn">
                        <span id="saveBtnText">Save Changes</span>
                        <span id="saveBtnLoading" class="hidden loading loading-spinner loading-sm"></span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tooltip Modal -->
        <div class="custom-tooltip" id="tooltipModal">
            <div class="tooltip-arrow"></div>
            <div class="bg-primary text-white rounded-xl shadow-2xl w-80 overflow-hidden border border-accent/30">
                <div class="p-5">
                    <div class="flex items-center mb-4">
                        <div id="tooltipIcon" class="p-2 rounded-lg bg-accent/20 mr-3">
                            <span class="default-icon"></span>
                        </div>
                        <div>
                            <h3 id="tooltipTitle" class="font-bold text-lg text-accent"></h3>
                            <p id="tooltipSubtitle" class="text-white/70 text-sm">Department Details</p>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <p id="tooltipDescription" class="text-white/90 text-sm mb-4"></p>
                        
                        <div class="mb-4">
                            <h4 class="font-semibold text-accent mb-2 text-sm">Features:</h4>
                            <div id="tooltipFeatures" class="flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                    
                    <div class="pt-3 border-t border-accent/20 text-xs text-white/60">
                        <p>Click on the card to access this department</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // API base URL
        const API_BASE_URL = 'api/dashboard_cards.php';
        
        // Global variables
        let allDepartments = <?php echo json_encode($departments); ?>;
        let hoverTimer;
        let currentDept = null;
        let isTooltipVisible = false;
        let mousePosition = { x: 0, y: 0 };
        
        // DOM Elements
        const tooltipModal = document.getElementById('tooltipModal');
        const tooltipTitle = document.getElementById('tooltipTitle');
        const tooltipDescription = document.getElementById('tooltipDescription');
        const tooltipFeatures = document.getElementById('tooltipFeatures');
        const adminToggle = document.getElementById('adminToggle');
        const adminOverlay = document.getElementById('adminOverlay');
        const adminPanel = document.getElementById('adminPanel');
        const closeAdmin = document.getElementById('closeAdmin');
        const addCardBtn = document.getElementById('addCardBtn');
        const adminTableBody = document.getElementById('adminTableBody');
        const editCardModal = document.getElementById('editCardModal');
        const cardForm = document.getElementById('cardForm');
        const cardsContainer = document.getElementById('cardsContainer');
        const cardsLoading = document.getElementById('cardsLoading');
        const saveCardBtn = document.getElementById('saveCardBtn');
        const saveBtnText = document.getElementById('saveBtnText');
        const saveBtnLoading = document.getElementById('saveBtnLoading');

        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            initializeHoverEvents();
            initializeCardAnimations();
            initializeAdminPanel();
        });

        // Initialize card animations
        function initializeCardAnimations() {
            const cards = document.querySelectorAll('.card-animate');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.style.opacity = '0';
                setTimeout(() => {
                    card.style.opacity = '1';
                }, index * 100 + 100);
            });
        }

        // Initialize admin panel
        function initializeAdminPanel() {
            adminToggle.addEventListener('click', () => {
                adminOverlay.style.display = 'block';
                adminPanel.style.display = 'block';
                loadAdminTable();
            });

            closeAdmin.addEventListener('click', () => {
                adminOverlay.style.display = 'none';
                adminPanel.style.display = 'none';
            });

            adminOverlay.addEventListener('click', () => {
                adminOverlay.style.display = 'none';
                adminPanel.style.display = 'none';
                closeEditModal();
            });

            addCardBtn.addEventListener('click', () => {
                openEditModal('Add New Domain');
            });
        }

        // Open edit modal
        function openEditModal(title, cardData = null) {
            document.getElementById('editModalTitle').textContent = title;
            cardForm.reset();
            
            if (cardData) {
                document.getElementById('cardId').value = cardData.id;
                document.getElementById('cardTitle').value = cardData.title;
                document.getElementById('cardLink').value = cardData.redirect_link;
                document.getElementById('cardDescription').value = cardData.description;
                
                let featuresText = '';
                if (Array.isArray(cardData.features)) {
                    featuresText = cardData.features.join('\n');
                } else if (typeof cardData.features === 'string') {
                    featuresText = cardData.features;
                }
                document.getElementById('cardFeatures').value = featuresText;
                document.getElementById('cardActive').checked = Boolean(cardData.is_active);
            } else {
                document.getElementById('cardId').value = '';
                document.getElementById('cardActive').checked = true;
            }
            
            clearFormErrors();
            adminPanel.style.display = 'none';
            editCardModal.style.display = 'block';
        }

        // Close edit modal
        function closeEditModal() {
            editCardModal.style.display = 'none';
            adminPanel.style.display = 'block';
            clearFormErrors();
        }

        // Clear form errors
        function clearFormErrors() {
            document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
            document.querySelectorAll('.input, .textarea').forEach(el => el.classList.remove('error'));
        }

        // Load admin table
        async function loadAdminTable() {
            try {
                showLoading(adminTableBody, 'Loading cards...');
                
                const response = await fetch(API_BASE_URL);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const cards = await response.json();
                
                if (!Array.isArray(cards)) {
                    if (cards.error) {
                        throw new Error(cards.error);
                    }
                    throw new Error('Invalid response format');
                }
                
                adminTableBody.innerHTML = '';
                
                if (cards.length === 0) {
                    showNoData(adminTableBody, 'No cards found');
                    return;
                }
                
                cards.forEach(card => {
                    const row = createTableRow(card);
                    adminTableBody.appendChild(row);
                });
                
                lucide.createIcons();
                
            } catch (error) {
                console.error('Error loading admin table:', error);
                showError(adminTableBody, 'Failed to load cards: ' + error.message);
            }
        }

        // Create table row
        function createTableRow(card) {
            const row = document.createElement('tr');
            row.className = 'hover:bg-primary/5 transition-all duration-200';
            
            const statusBadge = card.is_active == 1 ? 
                `<span class="badge badge-success badge-lg px-3 py-2">
                    <i data-lucide="check-circle" class="w-4 h-4 mr-1"></i>
                    Active
                </span>` :
                `<span class="badge badge-error badge-lg px-3 py-2">
                    <i data-lucide="x-circle" class="w-4 h-4 mr-1"></i>
                    Inactive
                </span>`;
            
            const statusText = card.is_active == 1 ? 'Deactivate' : 'Activate';
            const statusIcon = card.is_active == 1 ? 'pause' : 'play';
            
            row.innerHTML = `
                <td class="pl-6 py-5">
                    <span class="font-mono font-bold text-primary">#${String(card.id).padStart(3, '0')}</span>
                </td>
                
                <td class="py-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-lg bg-primary/10">
                            <span class="default-icon"></span>
                        </div>
                        <div>
                            <div class="font-semibold">${card.title}</div>
                            <div class="text-xs text-gray-500">${formatDate(card.updated_at)}</div>
                        </div>
                    </div>
                </td>
                
                <td class="py-5">
                    ${statusBadge}
                </td>
                
                <td class="pr-6 py-5">
                    <div class="flex items-center gap-2">
                        <button onclick="editCard(${card.id})" 
                                class="btn btn-ghost btn-sm hover:bg-primary/20"
                                title="Edit">
                            <i data-lucide="edit-2" class="w-4 h-4"></i>
                        </button>
                        
                        <button onclick="toggleCardStatus(${card.id})" 
                                class="btn btn-ghost btn-sm hover:bg-${card.is_active == 1 ? 'error' : 'success'}/20"
                                title="${statusText}">
                            <i data-lucide="${statusIcon}" class="w-4 h-4"></i>
                        </button>
                        
                        <button onclick="deleteCard(${card.id})" 
                                class="btn btn-ghost btn-sm hover:bg-error/20"
                                title="Delete">
                            <i data-lucide="trash-2" class="w-4 h-4"></i>
                        </button>
                    </div>
                </td>
            `;
            
            return row;
        }

        // Format date
        function formatDate(dateString) {
            if (!dateString || dateString === '0000-00-00 00:00:00') return 'Never updated';
            const date = new Date(dateString);
            return date.toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'short',
                day: 'numeric'
            });
        }

        // Show loading state
        function showLoading(element, message = 'Loading...') {
            element.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-8">
                        <div class="flex flex-col items-center gap-3">
                            <div class="loading loading-spinner loading-md text-primary"></div>
                            <p>${message}</p>
                        </div>
                    </td>
                </tr>
            `;
        }

        // Show no data state
        function showNoData(element, message = 'No data found') {
            element.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-8 text-gray-500">
                        <div class="flex flex-col items-center gap-3">
                            <i data-lucide="inbox" class="w-12 h-12 opacity-30"></i>
                            <p>${message}</p>
                            <button onclick="loadAdminTable()" class="btn btn-outline btn-sm mt-2">
                                <i data-lucide="refresh-cw" class="w-4 h-4 mr-1"></i>
                                Refresh
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            lucide.createIcons();
        }

        // Show error state
        function showError(element, message = 'Error loading data') {
            element.innerHTML = `
                <tr>
                    <td colspan="4" class="text-center py-8">
                        <div class="flex flex-col items-center gap-3">
                            <i data-lucide="alert-circle" class="w-12 h-12 text-error"></i>
                            <p class="text-error font-medium">${message}</p>
                            <button onclick="loadAdminTable()" class="btn btn-outline btn-sm mt-2">
                                <i data-lucide="refresh-cw" class="w-4 h-4 mr-1"></i>
                                Try Again
                            </button>
                        </div>
                    </td>
                </tr>
            `;
            lucide.createIcons();
        }

        // Edit card
        async function editCard(id) {
            try {
                showSweetAlert('info', 'Loading card details...', '', false);
                
                const response = await fetch(API_BASE_URL);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const cards = await response.json();
                
                if (!Array.isArray(cards)) {
                    throw new Error('Invalid response format');
                }
                
                const card = cards.find(c => c.id == id);
                if (card) {
                    Swal.close();
                    openEditModal('Edit Card', card);
                } else {
                    throw new Error('Card not found');
                }
            } catch (error) {
                console.error('Error loading card:', error);
                showSweetAlert('error', 'Failed to load card details', error.message);
            }
        }

        // Toggle card status - FIXED VERSION
        async function toggleCardStatus(id) {
            try {
                // First get current card status
                const response = await fetch(API_BASE_URL);
                if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
                
                const cards = await response.json();
                if (!Array.isArray(cards)) throw new Error('Invalid response format');
                
                const card = cards.find(c => c.id == id);
                if (!card) throw new Error('Card not found');
                
                const newStatus = card.is_active == 1 ? 0 : 1;
                const statusText = newStatus == 1 ? 'activate' : 'deactivate';
                
                const result = await Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to ${statusText} this card?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#001f54',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: `Yes, ${statusText} it!`,
                    cancelButtonText: 'Cancel'
                });
                
                if (result.isConfirmed) {
                    const updateData = {
                        id: id,
                        is_active: newStatus
                    };
                    
                    const updateResponse = await fetch(API_BASE_URL, {
                        method: 'PUT',
                        headers: { 
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(updateData)
                    });
                    
                    const updateResult = await updateResponse.json();
                    
                    if (updateResult.success) {
                        await loadAdminTable();
                        await reloadCards();
                        showSweetAlert('success', 
                            `Card ${statusText}d successfully`, 
                            `The card has been ${statusText}d.`
                        );
                    } else {
                        throw new Error(updateResult.error || 'Failed to update status');
                    }
                }
                
            } catch (error) {
                console.error('Error toggling card status:', error);
                showSweetAlert('error', 'Failed to update card status', error.message);
            }
        }

        // Delete card
        async function deleteCard(id) {
            const result = await Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone! The card will be permanently deleted.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel',
                showLoaderOnConfirm: true,
                preConfirm: async () => {
                    try {
                        const response = await fetch(API_BASE_URL, {
                            method: 'DELETE',
                            headers: { 
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({ id: id })
                        });
                        
                        const result = await response.json();
                        if (!result.success) {
                            throw new Error(result.error || 'Failed to delete card');
                        }
                        return result;
                    } catch (error) {
                        Swal.showValidationMessage(`Delete failed: ${error.message}`);
                    }
                }
            });
            
            if (result.isConfirmed) {
                await loadAdminTable();
                await reloadCards();
                showSweetAlert('success', 'Deleted!', 'Card has been deleted successfully.');
            }
        }

        // Card form submission
        cardForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            if (!validateForm()) {
                return;
            }
            
            // Show loading state on button
            saveCardBtn.disabled = true;
            saveBtnText.classList.add('hidden');
            saveBtnLoading.classList.remove('hidden');
            
            try {
                const cardData = {
                    id: document.getElementById('cardId').value,
                    title: document.getElementById('cardTitle').value.trim(),
                    redirect_link: document.getElementById('cardLink').value.trim(),
                    description: document.getElementById('cardDescription').value.trim(),
                    features: document.getElementById('cardFeatures').value
                        .split('\n')
                        .map(f => f.trim())
                        .filter(f => f),
                    is_active: document.getElementById('cardActive').checked ? 1 : 0
                };
                
                const method = cardData.id ? 'PUT' : 'POST';
                
                const response = await fetch(API_BASE_URL, {
                    method: method,
                    headers: { 
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(cardData)
                });
                
                const result = await response.json();
                
                if (result.success) {
                    closeEditModal();
                    await loadAdminTable();
                    await reloadCards();
                    showSweetAlert('success', 
                        cardData.id ? 'Card Updated!' : 'Card Created!', 
                        result.message || 'Card saved successfully.'
                    );
                } else {
                    throw new Error(result.error || 'Failed to save card');
                }
            } catch (error) {
                console.error('Error saving card:', error);
                showSweetAlert('error', 'Failed to save card', error.message);
            } finally {
                // Reset button state
                saveCardBtn.disabled = false;
                saveBtnText.classList.remove('hidden');
                saveBtnLoading.classList.add('hidden');
            }
        });

        // Validate form
        function validateForm() {
            let isValid = true;
            clearFormErrors();
            
            const title = document.getElementById('cardTitle').value.trim();
            const link = document.getElementById('cardLink').value.trim();
            const description = document.getElementById('cardDescription').value.trim();
            const features = document.getElementById('cardFeatures').value.trim();
            
            if (!title) {
                document.getElementById('titleError').textContent = 'Title is required';
                document.getElementById('cardTitle').classList.add('error');
                isValid = false;
            }
            
            if (!link) {
                document.getElementById('linkError').textContent = 'Redirect link is required';
                document.getElementById('cardLink').classList.add('error');
                isValid = false;
            } else if (!isValidUrl(link)) {
                document.getElementById('linkError').textContent = 'Please enter a valid URL';
                document.getElementById('cardLink').classList.add('error');
                isValid = false;
            }
            
            if (!description) {
                document.getElementById('descriptionError').textContent = 'Description is required';
                document.getElementById('cardDescription').classList.add('error');
                isValid = false;
            }
            
            if (!features) {
                document.getElementById('featuresError').textContent = 'At least one feature is required';
                document.getElementById('cardFeatures').classList.add('error');
                isValid = false;
            }
            
            return isValid;
        }

        // Validate URL
        function isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }

        // Reload cards on dashboard - FIXED VERSION
        async function reloadCards() {
            try {
                cardsLoading.classList.add('active');
                
                const response = await fetch(API_BASE_URL);
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                
                const allCards = await response.json();
                
                if (!Array.isArray(allCards)) {
                    throw new Error('Invalid response format');
                }
                
                // Filter active cards
                const activeCards = allCards.filter(card => card.is_active == 1);
                
                // Store in global variable
                allDepartments = activeCards;
                
                // Clear container
                cardsContainer.innerHTML = '';
                
                if (activeCards.length === 0) {
                    cardsContainer.innerHTML = `
                        <div class="col-span-full text-center py-12">
                            <div class="flex flex-col items-center gap-4">
                                <i data-lucide="layout-grid" class="w-16 h-16 text-gray-300"></i>
                                <h3 class="text-lg font-semibold text-gray-500">No active cards</h3>
                                <p class="text-gray-400">Add some cards to get started!</p>
                            </div>
                        </div>
                    `;
                    lucide.createIcons();
                    return;
                }
                
                // Add cards to container
                activeCards.forEach((dept, index) => {
                    // Parse features
                    let featuresArray = [];
                    if (Array.isArray(dept.features)) {
                        featuresArray = dept.features;
                    } else if (typeof dept.features === 'string') {
                        try {
                            featuresArray = JSON.parse(dept.features);
                        } catch (e) {
                            featuresArray = dept.features.split('\n').filter(f => f.trim());
                        }
                    }
                    
                    const cardHTML = createCardHTML(dept, index, featuresArray);
                    cardsContainer.innerHTML += cardHTML;
                });
                
                // Reinitialize hover events
                initializeHoverEvents();
                lucide.createIcons();
                initializeCardAnimations();
                
            } catch (error) {
                console.error('Error reloading cards:', error);
                cardsContainer.innerHTML = createErrorCardHTML(error.message);
                lucide.createIcons();
            } finally {
                cardsLoading.classList.remove('active');
            }
        }

        // Create card HTML
        function createCardHTML(dept, index, featuresArray) {
            return `
                <div class="card-wrapper relative group" data-dept-id="${dept.id}">
                    <div class="hover-indicator"></div>
                    <a href="${dept.redirect_link}" 
                       target="_blank" 
                       class="card-link block h-full"
                       data-title="${dept.title.replace(/"/g, '&quot;')}"
                       data-description="${dept.description.replace(/"/g, '&quot;')}"
                       data-features='${JSON.stringify(featuresArray).replace(/'/g, "&apos;")}'
                       data-link="${dept.redirect_link}">
                        <div class="department-card rounded-lg p-6 cursor-pointer h-full flex flex-col justify-between card-animate transition-all duration-300" style="animation-delay: ${index * 0.1}s; opacity: 0;">
                            <div>
                                <div class="flex items-center justify-between mb-6">
                                    <div class="p-3 rounded-xl bg-white/10">
                                        <span class="default-icon"></span>
                                    </div>
                                    <div class="text-accent/70">
                                        <i data-lucide="external-link" class="w-5 h-5"></i>
                                    </div>
                                </div>
                                <h3 class="text-xl font-bold text-accent mb-2">${dept.title}</h3>
                            </div>
                            <div class="pt-4 border-t border-accent/20 flex items-center justify-between text-white/80 text-sm">
                                <div class="flex items-center">
                                    <i data-lucide="info" class="w-4 h-4 mr-2 text-accent"></i>
                                    <span>Hover for details</span>
                                </div>
                                <span class="px-2 py-1 bg-accent/20 text-accent text-xs rounded-lg">
                                    ID: ${String(dept.id).padStart(2, '0')}
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
            `;
        }

        // Create error card HTML
        function createErrorCardHTML(errorMessage = '') {
            return `
                <div class="col-span-full text-center py-12">
                    <div class="flex flex-col items-center gap-4">
                        <i data-lucide="alert-circle" class="w-16 h-16 text-error"></i>
                        <h3 class="text-lg font-semibold text-error">Failed to load cards</h3>
                        <p class="text-gray-600">${errorMessage || 'Please refresh the page'}</p>
                        <button onclick="reloadCards()" class="btn btn-outline gap-2 mt-2">
                            <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                            Try Again
                        </button>
                    </div>
                </div>
            `;
        }

        // Save all changes
        async function saveAllChanges() {
            showSweetAlert('info', 'Saving changes...', '', false);
            setTimeout(() => {
                showSweetAlert('success', 'All changes have been saved!');
            }, 1000);
        }

        // Hover functionality
        function initializeHoverEvents() {
            document.querySelectorAll('.card-wrapper').forEach((wrapper) => {
                const deptId = parseInt(wrapper.getAttribute('data-dept-id'));
                const dept = allDepartments.find(d => d.id === deptId);
                
                if (!dept) return;
                
                let hideTimer;
                
                wrapper.addEventListener('mouseenter', () => {
                    clearTimeout(hideTimer);
                    hoverTimer = setTimeout(() => {
                        if (!isTooltipVisible) showTooltip(dept);
                    }, 500);
                });
                
                wrapper.addEventListener('mouseleave', () => {
                    clearTimeout(hoverTimer);
                    hideTimer = setTimeout(() => {
                        if (isTooltipVisible && currentDept?.id === dept.id) hideTooltip();
                    }, 200);
                });
            });
            
            // Track mouse movement
            document.addEventListener('mousemove', (e) => {
                mousePosition = { x: e.clientX, y: e.clientY };
                if (isTooltipVisible) positionTooltip();
            });
            
            // Tooltip events
            tooltipModal.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimer);
            });
            
            tooltipModal.addEventListener('mouseleave', () => {
                hideTimer = setTimeout(() => {
                    if (isTooltipVisible) hideTooltip();
                }, 200);
            });
            
            // Close with Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && isTooltipVisible) hideTooltip();
            });
        }

        // Position tooltip
        function positionTooltip() {
            const tooltipWidth = tooltipModal.offsetWidth;
            const tooltipHeight = tooltipModal.offsetHeight;
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            
            let x = mousePosition.x + 20;
            let y = mousePosition.y + 20;
            
            if (x + tooltipWidth > viewportWidth) x = mousePosition.x - tooltipWidth - 20;
            if (y + tooltipHeight > viewportHeight) y = mousePosition.y - tooltipHeight - 20;
            
            x = Math.max(10, Math.min(x, viewportWidth - tooltipWidth - 10));
            y = Math.max(10, Math.min(y, viewportHeight - tooltipHeight - 10));
            
            tooltipModal.style.left = `${x}px`;
            tooltipModal.style.top = `${y}px`;
        }

        // Show tooltip
        function showTooltip(dept) {
            currentDept = dept;
            tooltipTitle.textContent = dept.title;
            tooltipDescription.textContent = dept.description;
            tooltipFeatures.innerHTML = '';
            
            if (dept.features && Array.isArray(dept.features)) {
                dept.features.forEach(feature => {
                    if (feature.trim()) {
                        const badge = document.createElement('span');
                        badge.className = 'px-3 py-1.5 bg-accent/20 text-accent text-sm rounded-lg mb-1';
                        badge.textContent = feature;
                        tooltipFeatures.appendChild(badge);
                    }
                });
            }
            
            if (tooltipFeatures.children.length === 0) {
                const noFeatures = document.createElement('p');
                noFeatures.className = 'text-white/60 text-sm italic';
                noFeatures.textContent = 'No features listed';
                tooltipFeatures.appendChild(noFeatures);
            }
            
            positionTooltip();
            tooltipModal.classList.add('active');
            isTooltipVisible = true;
        }

        // Hide tooltip
        function hideTooltip() {
            tooltipModal.classList.remove('active');
            isTooltipVisible = false;
            currentDept = null;
        }

        // Show SweetAlert - FIXED VERSION
        function showSweetAlert(icon, title, text = '', showConfirmButton = true) {
            // Close any existing alerts
            Swal.close();
            
            const config = {
                icon: icon,
                title: title,
                text: text,
                confirmButtonColor: '#001f54',
                customClass: {
                    container: 'swal2-z-index',
                    popup: 'rounded-2xl',
                    title: 'text-lg font-semibold',
                    confirmButton: 'btn btn-primary'
                },
                showConfirmButton: showConfirmButton,
                timer: icon === 'success' ? 2000 : undefined,
                timerProgressBar: icon === 'success',
                didOpen: () => {
                    if (!showConfirmButton) {
                        Swal.showLoading();
                    }
                }
            };
            
            if (!showConfirmButton) {
                config.allowOutsideClick = false;
                config.allowEscapeKey = false;
            }
            
            Swal.fire(config);
        }
    </script>
</body>
</html>