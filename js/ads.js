const carousel = document.querySelector(".carousel");
const images = document.querySelectorAll(".carousel img");
let currentIndex = 0;

function updateCarousel() {
  const offset = -currentIndex * 100; // Dịch chuyển theo chỉ số
  carousel.style.transform = `translateX(${offset}%)`;
}

function showNextImage() {
  currentIndex = (currentIndex + 1) % images.length; // Quay vòng
  updateCarousel();
}

// Đảm bảo mỗi hình ảnh luôn giữ tỷ lệ 690x300
images.forEach((img) => {
  img.style.width = "100%"; // Độ rộng theo container cha
  img.style.height = "auto"; // Giữ tỷ lệ 690:300
});

// Tự động chuyển ảnh sau 3 giây
setInterval(showNextImage, 3000);
