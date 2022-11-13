document.addEventListener('DOMContentLoaded', () => {
    toggleElementsOnCheck(
        'advanced-config-switch',
        'is-advanced-config'
    );
});

function toggleElementsOnCheck(switcherClass, elementToggleClass){
    let advancedParamsSwitchSelector = document.getElementsByClassName(switcherClass);
    let advancedParamsSelector = document.getElementsByClassName(elementToggleClass);

    for (let i in advancedParamsSwitchSelector) {
        if (advancedParamsSwitchSelector[i].nodeType !== undefined){
            advancedParamsSwitchSelector[i].addEventListener('change', () =>{
                let isAdvancedParamsEnabled = advancedParamsSwitchSelector[i].getAttribute('value') === '1';

                for (let x in advancedParamsSelector) {
                    if (advancedParamsSelector[x].nodeType !== undefined){
                        advancedParamsSelector[x].classList[isAdvancedParamsEnabled ? 'remove' : 'add']('d-none');
                    }
                }
            })
        }
    }
}