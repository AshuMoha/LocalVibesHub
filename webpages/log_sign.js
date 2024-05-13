// Check if the user is logged in
const isLoggedIn = /* your logic to check if the user is logged in */;

// Function to update the navigation bar based on user login status
function updateNavbar() {
  const navbar = document.getElementById('navbar');
  const loginSignupLi = document.getElementById('log_sign');

  if (isLoggedIn) {
    // Update the navigation bar to display user profile instead of sign-in option
    loginSignupLi.innerHTML = '<a href="profile.html">Profile</a>';
  } else {
    // Reset the navigation bar to display sign-in option
    loginSignupLi.innerHTML = '<a href="login.html">Sign In</a>';
  }
}

// Call the function to update the navigation bar when the page loads
window.onload = updateNavbar;