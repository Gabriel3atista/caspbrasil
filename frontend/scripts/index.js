const input = document.querySelector('.form__input');
const addButton = document.querySelector('.form__button');
const deleteButton = document.querySelector('.form__button');

const observer = new Observer();

addButton.addEventListener('click', () => {
  observer.addName('Elon Musk');
});

deleteButton.addEventListener('click', () => {
  observer.deleteName(0);
});
