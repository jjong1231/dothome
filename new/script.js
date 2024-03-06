// 페이지 로딩 후 첫 번째 년도 항목을 활성화합니다.
document.addEventListener('DOMContentLoaded', function() {
  const firstYear = document.querySelector('.timeline-years ul li:first-child a');
  firstYear.classList.add('active');
});

// 년도 항목을 클릭하면 해당 연도의 내용이 나타나도록 합니다.
const yearLinks = document.querySelectorAll('.timeline-years ul li a');
yearLinks.forEach(function(link) {
  link.addEventListener('click', function(event) {
    event.preventDefault();
    const targetId = link.getAttribute('href');
    const targetYear = document.querySelector(targetId);
    smoothScroll(targetYear);
    activateYearLink(link);
  });
});

// 부드러운 스크롤 함수
function smoothScroll(target) {
  const targetPosition = target.getBoundingClientRect().top + window.pageYOffset;
  window.scrollTo({
    top: targetPosition,
    behavior: 'smooth'
  });
}

// 활성화된 년도 항목 스타일링
function activateYearLink(activeLink) {
  yearLinks.forEach(function(link) {
    link.classList.remove('active');
  });
  activeLink.classList.add('active');
}
