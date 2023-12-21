if (localStorage.getItem("isSmall") === "yes") {
    sidebarId.classList.add("small-sidebar");
} else {
    sidebarId.classList.remove("small-sidebar");
}

const toggleSidebar = () => {
    if (localStorage.getItem("isSmall") === "yes") {
        localStorage.setItem("isSmall", "no");
        sidebarId.classList.remove("small-sidebar");
    } else {
        localStorage.setItem("isSmall", "yes");
        sidebarId.classList.add("small-sidebar");
    }
};

// const body = document.querySelector('body');

// linkedUL = body.querySelector('.linked-ul');

// nav_links = linkedUL.querySelectorAll('.linked');
// nav_links.forEach(nav_link => {
//     nav_link.addEventListener('click', () => {
//         actives = linkedUL.querySelectorAll('.active');
//         actives.forEach(active => {
//             active.classList.remove('active');
//         });
//         // body.querySelector('.active').classList.remove('active');


//         nav_link.classList.add('active');

//     });
// });