@if(getWebConfig(name: 'firebase_message') && getWebConfig(name: 'firebase_message')['status'] == 1)
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/8.10.0/firebase-messaging.js"></script>
    <script>
        const firebaseConfig = {
            apiKey: "{{ getWebConfig(name: 'firebase_message')['apiKey'] ?? '' }}",
            authDomain: "{{ getWebConfig(name: 'firebase_message')['authDomain'] ?? '' }}",
            projectId: "{{ getWebConfig(name: 'firebase_message')['projectId'] ?? '' }}",
            storageBucket: "{{ getWebConfig(name: 'firebase_message')['storageBucket'] ?? '' }}",
            messagingSenderId: "{{ getWebConfig(name: 'firebase_message')['messagingSenderId'] ?? '' }}",
            appId: "{{ getWebConfig(name: 'firebase_message')['appId'] ?? '' }}"
        };
        firebase.initializeApp(firebaseConfig);
        const messaging = firebase.messaging();
    </script>
@endif

