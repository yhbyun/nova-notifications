import Echo from 'laravel-echo'

Nova.booting((Vue, router, store) => {
    Vue.component('notification-item', require('./components/NotificationItem'))
    Vue.component('notifications-dropdown', require('./components/NotificationsDropdown'))

    // router.addRoutes([
    //     {
    //         name: 'notifications',
    //         path: '/notifications',
    //         component: require('./components/Tool'),
    //     },
    // ])

    window.Pusher = require('pusher-js')

    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: 'nova-notifications',
        wsHost: Nova.config.wsHost,
        wsPort: Nova.config.wsPort,
        wssPort: Nova.config.wsPort,
        disableStats: true,
        encrypted: true,
        enabledTransports: ['ws', 'wss'],
    })
})
