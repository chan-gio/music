function selectNavItem(element) {
    // Remove the 'selected' class from all nav items
    var navItems = document.querySelectorAll('.nav-link');
    navItems.forEach(item => item.classList.remove('selected'));

    // Add the 'selected' class to the clicked nav item
    element.classList.add('selected');
}
