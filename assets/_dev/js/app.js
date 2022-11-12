document.addEventListener('DOMContentLoaded', () => {
    let appSwitchSelector = document.getElementsByClassName('app-switch-el');
    for (let i in appSwitchSelector) {
        let element = appSwitchSelector[i];

        if(typeof element  === 'object' && element.nodeType !== undefined){
            element.addEventListener('change', () =>{
                if (element.dataset.elementsToHidden) {
                    let elementsToHidden = element.dataset.elementsToHidden.split(',');
                    toggleClasses(elementsToHidden, false);
                }

                if (element.dataset.elementsToShow) {
                    let elementsToShow = element.dataset.elementsToShow.split(',');
                    toggleClasses(elementsToShow, true);
                }
            })
        }
    }
})

function toggleClasses(elementsToToggle, display)
{
    if (elementsToToggle.length) {
        for (let i in elementsToToggle) {
            let elementToToggle = document.getElementById(elementsToToggle[i]);
            if (elementToToggle){
                if (display) {
                    elementToToggle.classList.remove('d-none');
                } else {
                    elementToToggle.classList.add('d-none');
                }
            }
        }
    }
}