<div class="bg-[#001f54] pt-5 pb-4 flex flex-col fixed md:relative h-screen w-80 transition-all duration-300 ease-in-out shadow-xl sidebar-expandable" id="sidebar">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-between flex-shrink-0 px-4 mb-6 text-center">
        <h1 class="text-xl font-bold text-white flex items-center gap-2">
            <div class="h-8 w-8 bg-white rounded-lg flex items-center justify-center">
                <span class="text-[#001f54] font-bold"></span>
            </div>
            <span>LOGO HERE</span>
        </h1>
    </div>

    <!-- Navigation Menu - Only USM Section -->
    <div class="flex-1 flex flex-col overflow-hidden hover:overflow-y-auto">
        <nav class="flex-1 px-2 space-y-1">
            <!-- USER & SECURITY MANAGEMENT SECTION -->
            <div class="px-4 py-2 mt-2">
                <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">User & Security Management</p>
            </div>
            
            <!-- HR Management Dropdown -->
            <div class="relative group menu-dropdown">
                <button class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="flex items-center">
                        <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                            <i data-lucide="briefcase" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                        </div>
                        <span class="ml-3 sidebar-text">HR Department</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-auto transition-transform duration-200 group-hover:rotate-180 dropdown-arrow"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-content overflow-hidden transition-all duration-300 max-h-0 group-hover:max-h-96">
                    <div class="py-2 space-y-1">
                        <a href="<?php echo $base_url; ?>/USM/department_accounts.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="user-cog" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Department Accounts</span>
                        </a>
                       
                        <a href="<?php echo $base_url; ?>/USM/audit_trail&transaction.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="history" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Audit Trail & Transaction</span>
                        </a>

                        <a href="<?php echo $base_url; ?>/USM/login_logs.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="clipboard-list" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Login Logs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Logistics Management Dropdown -->
            <div class="relative group menu-dropdown">
                <button class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="flex items-center">
                        <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                            <i data-lucide="truck" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                        </div>
                        <span class="ml-3 sidebar-text">Logistic department</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-auto transition-transform duration-200 group-hover:rotate-180 dropdown-arrow"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-content overflow-hidden transition-all duration-300 max-h-0 group-hover:max-h-96">
                    <div class="py-2 space-y-1">
                        <a href="<?php echo $base_url; ?>/USM/department_accounts.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="user-cog" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Department Accounts</span>
                        </a>
                       
                        <a href="<?php echo $base_url; ?>/USM/audit_trail&transaction.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="history" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Audit Trail & Transaction</span>
                        </a>

                        <a href="<?php echo $base_url; ?>/USM/login_logs.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="clipboard-list" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Login Logs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Administration Dropdown -->
            <div class="relative group menu-dropdown">
                <button class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="flex items-center">
                        <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                            <i data-lucide="user-cog" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                        </div>
                        <span class="ml-3 sidebar-text">Administrative department</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-auto transition-transform duration-200 group-hover:rotate-180 dropdown-arrow"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-content overflow-hidden transition-all duration-300 max-h-0 group-hover:max-h-96">
                    <div class="py-2 space-y-1">
                        <a href="<?php echo $base_url; ?>/USM/department_accounts.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="user-cog" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Department Accounts</span>
                        </a>
                       
                        <a href="<?php echo $base_url; ?>/USM/audit_trail&transaction.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="history" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Audit Trail & Transaction</span>
                        </a>

                        <a href="<?php echo $base_url; ?>/USM/login_logs.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="clipboard-list" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Login Logs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Hotel Transactions Dropdown -->
            <div class="relative group menu-dropdown">
                <button class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="flex items-center">
                        <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                            <i data-lucide="building" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                        </div>
                        <span class="ml-3 sidebar-text">Hotel Department</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-auto transition-transform duration-200 group-hover:rotate-180 dropdown-arrow"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-content overflow-hidden transition-all duration-300 max-h-0 group-hover:max-h-96">
                    <div class="py-2 space-y-1">
                        <a href="<?php echo $base_url; ?>/USM/department_accounts.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="user-cog" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Department Accounts</span>
                        </a>
                       
                        <a href="<?php echo $base_url; ?>/USM/audit_trail&transaction.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="history" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Audit Trail & Transaction</span>
                        </a>

                        <a href="<?php echo $base_url; ?>/USM/login_logs.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="clipboard-list" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Login Logs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Restaurant Transactions Dropdown -->
            <div class="relative group menu-dropdown">
                <button class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="flex items-center">
                        <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                            <i data-lucide="utensils" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                        </div>
                        <span class="ml-3 sidebar-text">Restaurant Department</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-auto transition-transform duration-200 group-hover:rotate-180 dropdown-arrow"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-content overflow-hidden transition-all duration-300 max-h-0 group-hover:max-h-96">
                    <div class="py-2 space-y-1">
                        <a href="<?php echo $base_url; ?>/USM/department_accounts.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="user-cog" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Department Accounts</span>
                        </a>
                       
                        <a href="<?php echo $base_url; ?>/USM/audit_trail&transaction.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="history" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Audit Trail & Transaction</span>
                        </a>

                        <a href="<?php echo $base_url; ?>/USM/login_logs.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="clipboard-list" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Login Logs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Financials Dropdown -->
            <div class="relative group menu-dropdown">
                <button class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="flex items-center">
                        <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                            <i data-lucide="dollar-sign" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                        </div>
                        <span class="ml-3 sidebar-text">Financials Department</span>
                    </div>
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-auto transition-transform duration-200 group-hover:rotate-180 dropdown-arrow"></i>
                </button>
                
                <!-- Dropdown Menu -->
                <div class="dropdown-content overflow-hidden transition-all duration-300 max-h-0 group-hover:max-h-96">
                    <div class="py-2 space-y-1">
                        <a href="<?php echo $base_url; ?>/USM/department_accounts.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="user-cog" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Department Accounts</span>
                        </a>
                       
                        <a href="<?php echo $base_url; ?>/USM/audit_trail&transaction.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="history" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Audit Trail & Transaction</span>
                        </a>

                        <a href="<?php echo $base_url; ?>/USM/login_logs.php" class="flex items-center px-4 py-2 text-sm rounded-lg transition-all hover:bg-blue-600/30 text-blue-100 hover:text-white group/item ml-8">
                            <i data-lucide="clipboard-list" class="w-4 h-4 mr-3 text-[#F7B32B] group-hover/item:text-white"></i>
                            <span>Login Logs</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- SETTINGS SECTION -->
            <div class="px-4 py-2 mt-8">
                <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Settings</p>
            </div>
            
            <!-- Settings -->
            <a href="#" class="block">
                <div class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                        <i data-lucide="settings" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                    </div>
                    <span class="ml-3 sidebar-text">Settings</span>
                </div>
            </a>

            <!-- ADMIN SECTION -->
            <div class="px-4 py-2 mt-4">
                <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Administration</p>
            </div>
            
            <!-- Admin -->
            <a href="#" class="block">
                <div class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                        <i data-lucide="shield" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                    </div>
                    <span class="ml-3 sidebar-text">Admin</span>
                </div>
            </a>

            <!-- PROFILE SECTION -->
            <div class="px-4 py-2 mt-4">
                <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Profile</p>
            </div>
            
            <!-- Profile -->
            <a href="#" class="block">
                <div class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                        <i data-lucide="user" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                    </div>
                    <span class="ml-3 sidebar-text">Profile</span>
                </div>
            </a>

            <!-- MAIN DOMAIN SECTION -->
            <div class="px-4 py-2 mt-4">
                <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Quick Access</p>
            </div>
            
            <!-- Main Domain Shortcut -->
            <a href="#" class="block">
                <div class="flex items-center px-4 py-3 text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                        <i data-lucide="external-link" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                    </div>
                    <span class="ml-3 sidebar-text">Main Domain</span>
                </div>
            </a>

            <!-- Logout -->
            <div class="px-4 py-2 mt-8">
                <p class="text-xs font-semibold text-blue-300 uppercase tracking-wider">Account</p>
            </div>
            <div class="px-4 py-3">
                <button type="button" class="flex items-center w-full text-sm font-medium rounded-lg transition-all hover:bg-blue-600/50 text-white group">
                    <div class="p-1.5 rounded-lg bg-blue-800/30 group-hover:bg-blue-700/50 transition-colors">
                        <i data-lucide="log-out" class="w-5 h-5 text-[#F7B32B] group-hover:text-white"></i>
                    </div>
                    <span class="ml-3 sidebar-text">Logout</span>
                </button>
            </div>
        </nav>
    </div>
</div>

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
</style>

<script>
// Initialize Lucide icons and handle dropdown interactions
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Handle main dropdown hover states
    const dropdowns = document.querySelectorAll('.menu-dropdown');
    
    // Main dropdown functionality
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', function() {
            const content = this.querySelector('.dropdown-content');
            content.style.maxHeight = content.scrollHeight + 'px';
        });
        
        dropdown.addEventListener('mouseleave', function() {
            const content = this.querySelector('.dropdown-content');
            content.style.maxHeight = '0';
        });
    });

    // Add click functionality for mobile
    if (window.innerWidth < 768) {
        dropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('button');
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const content = this.parentElement.querySelector('.dropdown-content');
                const isOpen = content.style.maxHeight && content.style.maxHeight !== '0px';
                
                // Close all other dropdowns
                dropdowns.forEach(otherDropdown => {
                    if (otherDropdown !== dropdown) {
                        otherDropdown.querySelector('.dropdown-content').style.maxHeight = '0';
                    }
                });
                
                // Toggle current dropdown
                if (isOpen) {
                    content.style.maxHeight = '0';
                } else {
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            });
        });
    }
});
</script>