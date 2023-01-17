(() => {
  const scrollUp = document.querySelector(".netsqure-scroll-top");

  console.log({ scrollUp });

  if (!scrollUp) return;

  window.addEventListener("scroll", () => {
    if (window.pageYOffset > 250) {
      scrollUp.classList.add("show");
    } else {
      scrollUp.classList.remove("show");
    }
  });

  scrollUp.addEventListener("click", () => {
    window.scrollTo({
      top: 0,
      behavior: "smooth",
    });
  });
})();
