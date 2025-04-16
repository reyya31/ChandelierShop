// ======= Mobile Navigation Toggle =======
const menuBtn = document.getElementById('menu-btn');
const navLinks = document.getElementById('nav-links');
const navSearch = document.getElementById('nav-search');

// Toggle navigation and search visibility on mobile menu button click
menuBtn.addEventListener('click', () => {
    navLinks.classList.toggle('open');
    navSearch.classList.toggle('open');
});

// Close menu if clicked outside
document.addEventListener('click', (event) => {
    const isClickInsideMenu = navLinks.contains(event.target) || menuBtn.contains(event.target);
    const isClickInsideSearch = navSearch.contains(event.target);

    if (!isClickInsideMenu && !isClickInsideSearch) {
        navLinks.classList.remove('active');
        navSearch.classList.remove('active');
    }
});

// ======= Search Functionality =======
const searchInput = navSearch.querySelector('input');
const searchIcon = navSearch.querySelector('span'); // Assuming the icon is a span

searchIcon.addEventListener('click', () => {
    handleSearch();
});

searchInput.addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
        event.preventDefault();
        handleSearch();
    }
});

// Handle search input
function handleSearch() {
    const query = searchInput.value.trim();

    if (query) {
        // Replace this with your actual search logic
        alert(`Searching for: ${query}`);
        // Example: window.location.href = `/search?query=${encodeURIComponent(query)}`;
    } else {
        alert('Please enter a search query.');
    }
}

// ======= Product Image Thumbnail Click Handler =======
function changeImage(element) {
    const mainImage = document.getElementById("currentImage");
    mainImage.src = element.src;
}
