class Observer {
  constructor() {
    this.names = ['Gabriel Batista'];
    this.list = document.querySelector('.list');
    
    this.render(this.names);
  }

  update(names) {
    this.render(names);
  }

  render(names) {
    console.log(names);
    
    names.forEach((name, index) => {
      this.list.innerHTML = '';

      this.list.insertAdjacentHTML('beforeend', `
        <li class="list__item">
          <div class="item__content">
            <div class="item__index">${index + 1}.</div>
            <p class="item__text">${name}</p>
          </div>
          <div class="item__action">
            <div class="item__action-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path fill="currentColor" d="M6.4 19L5 17.6l5.6-5.6L5 6.4L6.4 5l5.6 5.6L17.6 5L19 6.4L13.4 12l5.6 5.6l-1.4 1.4l-5.6-5.6z"/>
              </svg>
            </div>
          </div>
        </li>
      `);
    });
  }

  addName(name) {
    this.names.push(name);
    this.update(this.names);
  }

  deleteName(index) {
    this.names.splice(index, 1);
    this.update(this.names); 
  }
}