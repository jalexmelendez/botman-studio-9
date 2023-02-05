<script>
    // Example ussage of the fullscreen widget
    const welcomeMessage = "{{ $welcome }}";
    const chatServer = "/api/botman";
 
    // Create a new observer instance:
    const observer = new MutationObserver(function() {
        if (document.getElementById('botmanChatRoot')) {
            // You must wait until the react component is inserted on the body!
            window.BotmanInstance.chatServer = chatServer;
            window.chatInstance.sayAsBot(welcomeMessage);
            disconectObserver();
        }
    });

    // Set configuration object:
    const config = { childList: true };
    
    // Start the observer
    observer.observe(document.body, config);

    function disconectObserver() {
        observer.disconnect();
    }

</script>
@vite(['resources/js/botman/fullscreen.js', 'resources/css/chat.css'])