const modal = document.querySelector("#modal");
const openModal = document.querySelector(".open-button");
const closeModal = document.querySelector(".close-button");

openModal.addEventListener("click", () => {
  modal.showModal();
});

closeModal.addEventListener("click", () => {
  modal.close();
});

const modal1 = document.querySelector("#modal1");
const openModal1 = document.querySelector(".open-button1");
const closeModal1 = document.querySelector(".close-button1");

openModal1.addEventListener("click", () => {
  modal1.showModal();
});

closeModal1.addEventListener("click", () => {
  modal1.close();
});
