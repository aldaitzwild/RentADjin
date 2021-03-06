<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)

return [
    'index' => ['HomeController', 'index',],
    'items' => ['ItemController', 'index',],
    'items/edit' => ['ItemController', 'edit', ['id']],
    'items/show' => ['ItemController', 'show', ['id']],
    'items/add' => ['ItemController', 'add',],
    'items/delete' => ['ItemController', 'delete',],
    'user/add' => ['UserController', 'add'],
    'user' => ['UserController', 'list'],
    '' => ['WelcomeController', 'index',],
    'admin' => ['AdminController', 'index',],
    'admin/genie/add' => ['GenieController', 'add',],
    'admin/genie' => ['AdminController', 'showGenie', ['id']],
    'admin/genie/update' => ['AdminController', 'showUpdateGenie', ['id']],
    'admin/genie/delete' => ['AdminController', 'deleteGenie', ['id']],
    'genies' => ['GenieController', 'showAllGenies', ['specialty']],
    'admin/genie/update/process' => ['GenieController', 'update', ['id']],
    'admin/specialty/add' => ['SpecialtyController', 'add',],
    'admin/user/add' => ['UserController', 'add',],
    'genies/booking' => ['BookingController', 'add', ['id']],
    'connection' => ['UserController', 'selectUser'],
    'genies/show' => ['GenieController', 'showGenie', ['id']],
    'genies/review' => ['GenieController', 'addReview'],
    'logout' => ['UserController', 'logout']
];
