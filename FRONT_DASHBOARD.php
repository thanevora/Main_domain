<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Department Dashboard</title>
    <?php include 'INCLUDES/header.php'; ?>
    <!-- Tailwind CSS with DaisyUI -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@4.12.13/dist/full.min.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <!-- SweetAlert -->
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
        
        /* Updated card style - removed glass effect */
        .department-card {
            background: linear-gradient(135deg, #001f54 0%, #001c4a 100%);
            border: 1px solid rgba(247, 179, 43, 0.2);
        }
        
        .department-card:hover {
            background: linear-gradient(135deg, #001f54 0%, #002368 100%);
            border: 1px solid rgba(247, 179, 43, 0.5);
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0, 31, 84, 0.3);
        }
        
        /* Custom tooltip styles */
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
        
        /* Hover timer indicator */
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
        
        /* Animation for cards */
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
        
        /* Custom scrollbar */
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
    </style>
</head>
<body class="bg-white">
    <div class="content-wrapper w-full">
        <!-- Navbar -->
        <?php include 'INCLUDES/navbar.php'; ?>

        <!-- Main Content -->
        <main class="max-w-8xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Header Section -->
            <div class="mb-10">
                <h1 class="text-4xl font-bold text-primary mb-3">Department Dashboard</h1>
                <p class="text-gray-600 text-lg">Hover over department cards to view details. Click to access the system.</p>
                
                
            </div>

            <!-- Cards Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
                <?php
                $departments = [
                    [
                        'id' => 1,
                        'title' => 'Human Resource 1',
                        'icon' => 'users',
                        'description' => 'Complete HR management system handling employee records, payroll processing, benefits administration, and compliance management.',
                        'features' => ['Employee Records', 'Payroll System', 'Benefits Admin', 'Compliance'],
                        'link' => 'https://example.com/hr1'
                    ],
                    [
                        'id' => 2,
                        'title' => 'Human Resource 2',
                        'icon' => 'user-cog',
                        'description' => 'Advanced HR analytics and recruitment management system with performance tracking and workforce planning tools.',
                        'features' => ['HR Analytics', 'Recruitment Tools', 'Performance Tracking', 'Workforce Planning'],
                        'link' => 'https://example.com/hr2'
                    ],
                    [
                        'id' => 3,
                        'title' => 'Human Resource 3',
                        'icon' => 'briefcase',
                        'description' => 'Training and development management system for employee skill development and compliance training programs.',
                        'features' => ['Training Programs', 'Skill Development', 'Compliance Training', 'Certifications'],
                        'link' => 'https://example.com/hr3'
                    ],
                    [
                        'id' => 4,
                        'title' => 'Human Resource 4',
                        'icon' => 'file-text',
                        'description' => 'Documentation and reporting system for HR policies, employee documentation, and regulatory reporting.',
                        'features' => ['Policy Management', 'Documentation', 'Reporting Tools', 'Regulatory Compliance'],
                        'link' => 'https://example.com/hr4'
                    ],
                    [
                        'id' => 5,
                        'title' => 'Logistics 1',
                        'icon' => 'truck',
                        'description' => 'Transportation and fleet management system with real-time tracking, route optimization, and delivery scheduling.',
                        'features' => ['Fleet Tracking', 'Route Optimization', 'Delivery Scheduling', 'Fuel Management'],
                        'link' => 'https://example.com/logistics1'
                    ],
                    [
                        'id' => 6,
                        'title' => 'Logistics 2',
                        'icon' => 'package',
                        'description' => 'Inventory and warehouse management system with supply chain optimization and stock level monitoring.',
                        'features' => ['Inventory Control', 'Warehouse Management', 'Supply Chain', 'Stock Monitoring'],
                        'link' => 'https://example.com/logistics2'
                    ],
                    [
                        'id' => 7,
                        'title' => 'Administrative',
                        'icon' => 'clipboard-list',
                        'description' => 'Comprehensive office administration system for operational coordination, document management, and administrative support.',
                        'features' => ['Office Operations', 'Document Management', 'Administrative Support', 'Coordination'],
                        'link' => 'https://example.com/administrative'
                    ],
                    [
                        'id' => 8,
                        'title' => 'Financials',
                        'icon' => 'dollar-sign',
                        'description' => 'Complete financial management system including accounting, budgeting, financial reporting, and expense management.',
                        'features' => ['Accounting', 'Budgeting', 'Financial Reports', 'Expense Management'],
                        'link' => 'https://example.com/financials'
                    ],
                    [
                        'id' => 9,
                        'title' => 'Core Transaction 1 (HOTEL)',
                        'icon' => 'building',
                        'description' => 'Hotel management system for reservations, guest services, room management, and billing operations.',
                        'features' => ['Reservation System', 'Guest Management', 'Room Management', 'Billing'],
                        'link' => 'https://example.com/hotel'
                    ],
                    [
                        'id' => 10,
                        'title' => 'Core Transaction 2 (RESTAURANT)',
                        'icon' => 'utensils',
                        'description' => 'Restaurant management system with POS, order management, table reservations, and inventory control.',
                        'features' => ['POS System', 'Order Management', 'Table Reservations', 'Inventory Control'],
                        'link' => 'https://example.com/restaurant'
                    ]
                ];
                ?>

                <?php foreach ($departments as $index => $dept): ?>
                <div class="card-wrapper relative group" data-dept-id="<?php echo $dept['id']; ?>">
                    <div class="hover-indicator"></div>
                    <a href="<?php echo $dept['link']; ?>" 
                       target="_blank" 
                       class="card-link block h-full"
                       data-title="<?php echo htmlspecialchars($dept['title']); ?>"
                       data-icon="<?php echo $dept['icon']; ?>"
                       data-description="<?php echo htmlspecialchars($dept['description']); ?>"
                       data-features='<?php echo json_encode($dept['features']); ?>'
                       data-link="<?php echo $dept['link']; ?>">
                        <!-- Changed from glass-card to department-card and rounded-lg -->
                        <div class="department-card rounded-lg p-6 cursor-pointer h-full flex flex-col justify-between card-animate transition-all duration-300">
                            <div>
                                <div class="flex items-center justify-between mb-6">
                                    <div class="p-3 rounded-xl bg-white/10">
                                        <i data-lucide="<?php echo $dept['icon']; ?>" class="w-8 h-8 text-accent"></i>
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

        
        </main>

        <!-- Footer -->
        <footer class="mt-12 border-t border-gray-200 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-6 md:mb-0">
                       
                        <div class="ml-4">
    <!-- Logo with image -->
    <div class="flex items-center space-x-3">
        <div class="relative w-10 h-10">
            <!-- Image placeholder - replace src with your actual logo -->
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

    <!-- Tooltip Modal -->
    <div class="custom-tooltip" id="tooltipModal">
        <div class="tooltip-arrow"></div>
        <div class="bg-primary text-white rounded-xl shadow-2xl w-80 overflow-hidden border border-accent/30">
            <div class="p-5">
                <div class="flex items-center mb-4">
                    <div id="tooltipIcon" class="p-2 rounded-lg bg-accent/20 mr-3">
                        <i data-lucide="users" class="w-6 h-6 text-accent"></i>
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
                
                
            </div>
        </div>
    </div>

    <script>
        // Initialize Lucide icons
        lucide.createIcons();
        
        // DOM Elements
        const tooltipModal = document.getElementById('tooltipModal');
        const tooltipTitle = document.getElementById('tooltipTitle');
        const tooltipIcon = document.getElementById('tooltipIcon');
        const tooltipDescription = document.getElementById('tooltipDescription');
        const tooltipFeatures = document.getElementById('tooltipFeatures');
        const tooltipVisitBtn = document.getElementById('tooltipVisitBtn');
        
        // Variables for hover detection
        let hoverTimer;
        let currentDept = null;
        let isTooltipVisible = false;
        let mousePosition = { x: 0, y: 0 };
        
        // Department data from PHP
        const departments = <?php echo json_encode($departments); ?>;
        
        // Update mouse position
        document.addEventListener('mousemove', (e) => {
            mousePosition = { x: e.clientX, y: e.clientY };
            
            // Update tooltip position if visible
            if (isTooltipVisible) {
                positionTooltip();
            }
        });
        
        // Position tooltip near mouse
        function positionTooltip() {
            const tooltip = document.getElementById('tooltipModal');
            const tooltipWidth = tooltip.offsetWidth;
            const tooltipHeight = tooltip.offsetHeight;
            
            // Get viewport dimensions
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            
            // Calculate initial position (to the right of cursor)
            let x = mousePosition.x + 20;
            let y = mousePosition.y + 20;
            
            // Adjust if tooltip would go off screen horizontally
            if (x + tooltipWidth > viewportWidth) {
                x = mousePosition.x - tooltipWidth - 20;
            }
            
            // Adjust if tooltip would go off screen vertically
            if (y + tooltipHeight > viewportHeight) {
                y = mousePosition.y - tooltipHeight - 20;
            }
            
            // Ensure minimum margins
            x = Math.max(10, Math.min(x, viewportWidth - tooltipWidth - 10));
            y = Math.max(10, Math.min(y, viewportHeight - tooltipHeight - 10));
            
            tooltip.style.left = `${x}px`;
            tooltip.style.top = `${y}px`;
        }
        
        // Show tooltip with department details
        function showTooltip(dept) {
            currentDept = dept;
            
            // Update tooltip content
            tooltipTitle.textContent = dept.title;
            
            // Update icon
            const iconElement = tooltipIcon.querySelector('i');
            if (iconElement) {
                iconElement.setAttribute('data-lucide', dept.icon);
                lucide.createIcons();
            }
            
            // Update description
            tooltipDescription.textContent = dept.description;
            
            // Update features
            tooltipFeatures.innerHTML = '';
            dept.features.forEach(feature => {
                const badge = document.createElement('span');
                badge.className = 'px-2 py-1 bg-accent/20 text-accent text-xs rounded-lg';
                badge.textContent = feature;
                tooltipFeatures.appendChild(badge);
            });
            
          
            
            // Position and show tooltip
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
        
        // Set up hover events for cards
        document.querySelectorAll('.card-wrapper').forEach((wrapper) => {
            const deptId = parseInt(wrapper.getAttribute('data-dept-id'));
            const dept = departments.find(d => d.id === deptId);
            
            if (!dept) return;
            
            let hideTimer;
            
            wrapper.addEventListener('mouseenter', () => {
                // Clear any pending hide timer
                clearTimeout(hideTimer);
                
                // Start hover timer
                hoverTimer = setTimeout(() => {
                    if (!isTooltipVisible) {
                        showTooltip(dept);
                    }
                }, 500); // 0.5 second delay
            });
            
            wrapper.addEventListener('mouseleave', () => {
                // Clear hover timer
                clearTimeout(hoverTimer);
                
                // Set timer to hide tooltip
                hideTimer = setTimeout(() => {
                    if (isTooltipVisible && currentDept?.id === dept.id) {
                        hideTooltip();
                    }
                }, 200);
            });
            
            // Also handle events on the tooltip itself
            tooltipModal.addEventListener('mouseenter', () => {
                clearTimeout(hideTimer);
            });
            
            tooltipModal.addEventListener('mouseleave', () => {
                hideTimer = setTimeout(() => {
                    if (isTooltipVisible && currentDept?.id === dept.id) {
                        hideTooltip();
                    }
                }, 200);
            });
        });
        
        // Handle direct card clicks
        document.querySelectorAll('.card-link').forEach((link) => {
            link.addEventListener('click', function(e) {
                // If tooltip is visible, prevent default and use tooltip button
                if (isTooltipVisible) {
                    e.preventDefault();
                    e.stopPropagation();
                    return;
                }
                
                // Otherwise, show confirmation dialog
                e.preventDefault();
                const deptId = this.closest('.card-wrapper').getAttribute('data-dept-id');
                const dept = departments.find(d => d.id == deptId);
                
                if (!dept) return;
                
                Swal.fire({
                    title: `Redirecting to ${dept.title}`,
                    text: 'You will be redirected to the department management system. Do you want to proceed?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#001f54',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Yes, continue',
                    cancelButtonText: 'Cancel',
                    background: '#ffffff',
                    color: '#1f2937',
                    customClass: {
                        title: 'text-gray-900',
                        htmlContainer: 'text-gray-600'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(dept.link, '_blank');
                    }
                });
            });
        });
        
        // Add animation delay to cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.card-animate');
            cards.forEach((card, index) => {
                card.style.animationDelay = `${index * 0.1}s`;
                card.style.opacity = '0';
                setTimeout(() => {
                    card.style.opacity = '1';
                }, index * 100 + 100);
            });
        });
        
        // Close tooltip with Escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && isTooltipVisible) {
                hideTooltip();
            }
        });
        
        // Close tooltip when clicking outside
        document.addEventListener('click', function(e) {
            if (isTooltipVisible && !tooltipModal.contains(e.target) && 
                !e.target.closest('.card-wrapper')) {
                hideTooltip();
            }
        });
    </script>
</body>
</html>