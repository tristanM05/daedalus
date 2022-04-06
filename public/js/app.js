class Portfolio{

    /**
     * fait defiller la fenetre jusqu'a l'element
     * @param {HTMLELEMENT} element 
     * @param {int} offset
     */
    scrollTo(element, offset = 0){
        window.scrollTo({
            behavior: 'smooth',
            left: 0,
            top: element.offsetTop - offset
        })
    }
}

new Portfolio('#js-portfolio')