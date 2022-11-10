document.addEventListener('DOMContentLoaded', (e) => {
    Vue.component('step1', {
        template: '#step1',
        props: [
            'currentStep',
            'step1',
            'id'
        ]
    });

    Vue.component('step2', {
        template: '#step2',
        props: [
            'currentStep',
            'step2',
            'id'
        ]
    });

    Vue.component('step3', {
        template: '#step3',
        props: [
            'currentStep',
            'step1',
            'step2',
            'id'
        ]
    });

    var app = new Vue({
        el: '#app',
        data: {
            currentStep: 1,
            step1: {
                name: '',
                email: ''
            },
            step2: {
                city: '',
                state: ''
            }
        },
        ready: function() {
            console.log('ready');
        },
        methods: {
            goToStep: function(step) {
                this.currentStep = step;
            }
        }
    });
});