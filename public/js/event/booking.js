const form = document.getElementById('paymentForm');
const stripeClient = Stripe(form.dataset.paymentKey);

if(form.dataset.intentSecret !== ''){
    const elements = stripeClient.elements({
        clientSecret: form.dataset.intentSecret,
    });
    
    const paymentElements = elements.create('payment');
    paymentElements.mount('.paymentWidgets');
    
    let processing = false;
    form.addEventListener('submit', e => {
        e.preventDefault();
        if(processing){
            return;
        }
    
        processing = true;
        const button = document.getElementById('paymentButton');
        const error = document.getElementById('paymentError');
    
        button.classList.add('loading');
        error.classList.add('hide');
        stripeClient.confirmPayment({
            elements, 
            confirmParams: {
                return_url: window.location.href,
            }
        }).then(result => {
            if(result.error){
                button.classList.remove('loading');
                processing = false;
                error.innerText = result.error.message;
                error.classList.remove('hide');
            }
        });
    });
}
