
  // Wait until the page loads
  window.addEventListener("DOMContentLoaded", function () {
    // Select all messages (success or error)
    const messages = document.querySelectorAll(".green, .error");

    // Add fade-out class to each
    messages.forEach(msg => {
      msg.classList.add("fade-out");
    });
  });

