<script>
// Highlight active nav link based on scroll position
document.addEventListener("DOMContentLoaded", function () {
  const sections = document.querySelectorAll("section[id]");
  const navLinks = document.querySelectorAll(".navbar-nav .nav-link");

  window.addEventListener("scroll", () => {
    let scrollY = window.pageYOffset;

    sections.forEach((current) => {
      const sectionHeight = current.offsetHeight;
      const sectionTop = current.offsetTop - 60;
      const sectionId = current.getAttribute("id");

      if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
        navLinks.forEach((link) => {
          link.classList.remove("active");
          if (link.getAttribute("href") === `#${sectionId}`) {
            link.classList.add("active");
          }
        });
      }
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const params = new URLSearchParams(window.location.search);
  const status = params.get("sent");
  if (!status) return;

  const alert = document.createElement("div");
  alert.className = "alert " + (status === "1" ? "alert-success" : "alert-danger");
  alert.textContent =
    status === "1"
      ? "✅ Thank you! Your message has been sent."
      : "❌ Sorry, there was an error sending your message. Please try again.";
  document.querySelector("#contact form").prepend(alert);

  history.replaceState({}, document.title, window.location.pathname + "#contact");
});

</script>


