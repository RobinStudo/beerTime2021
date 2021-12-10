const form = document.getElementById('paymentForm');
const stripeClient = Stripe(form.dataset.paymentKey);
const elements = stripeClient.elements({
    clientSecret: form.dataset.intentSecret,
});

const paymentElements = elements.create('payment');
paymentElements.mount('.paymentWidgets');

form.addEventListener('submit', e => {
    e.preventDefault();

    stripeClient.confirmPayment({
        elements, 
        confirmParams: {
            return_url: window.location.href,
        }
    });
});