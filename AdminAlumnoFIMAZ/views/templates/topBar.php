 <!-- Top bar -->
 <div class="flex justify-between items-center mb-6">
     <button class="lg:hidden btn btn-primary mr-3 rounded-box" onclick="toggleSidebar()"> <i class="fa-solid fa-bars"></i> Menu</button>
     <div class="relative">
         <input type="text" placeholder="Search" class="input input-bordered w-full max-w-xs rounded-box" />
     </div>
     <div class="flex items-center space-x-4">

         <div class="dropdown dropdown-end z-50">
             <button class="btn btn-ghost btn-circle">
                 <i class="fa-solid fa-ellipsis-vertical"></i>
             </button>
             <ul tabindex="0" class="mt-3 p-2 shadow menu menu-compact dropdown-content bg-base-100 rounded-box w-52">
                 <li>
                     <a href="#" class="justify-between">
                         Profile
                         <span class="badge">New</span>
                     </a>
                 </li>
                 <li><a href="#">Settings</a></li>
                 <li><a href="../controllers/miniController/logoutMiniC.php">Logout</a></li>
             </ul>
         </div>
         <div class="avatar">
             <div class="mask rounded w-8">
                 <img src="<?php echo BASE_URL; ?>public/img/logofimazlight.png" />
             </div>
         </div>
     </div>
 </div>