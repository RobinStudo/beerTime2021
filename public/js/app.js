const notifications = document.querySelectorAll('.notification-manager .notification');

setTimeout(() => {
    for(const notification of notifications){
        notification.style.opacity = 0;
        setTimeout(() => {
            notification.remove();
        }, 500);
    }
}, 5000);

for(const notification of notifications){
    notification.querySelector('.notification-close').addEventListener('click', () => {
        notification.remove();
    });
}