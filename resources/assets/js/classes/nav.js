class Nav {
  constructor() { }

  dropdown(element = ".dropdown-button", params = {}) {
    $(element).dropdown(params);
  }
}

export default Nav;