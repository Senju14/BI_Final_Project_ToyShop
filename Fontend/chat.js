document.addEventListener("DOMContentLoaded", function () {
    const chatButton = document.getElementById("chatButton");
    const chatBox = document.getElementById("chatBox");
    const closeChat = document.getElementById("closeChat");
    const sendMessageButton = document.getElementById("sendMessage");
    const chatInput = document.getElementById("chatInput");
    const chatMessages = document.getElementById("chatMessages");
  
    // Toggle chat box visibility
    chatButton.addEventListener("click", () => {
      chatBox.classList.toggle("hidden");
    });
  
    closeChat.addEventListener("click", () => {
      chatBox.classList.add("hidden");
    });
  
    // Send message
    sendMessageButton.addEventListener("click", () => {
      const messageText = chatInput.value.trim();
      if (messageText) {
        addMessage(messageText, "sent");
        chatInput.value = "";
        setTimeout(() => {
          addMessage("Thank you for your message! We'll reply shortly.", "received");
        }, 1000);
      }
    });
  
    // Add message to chat
    function addMessage(text, type) {
      const message = document.createElement("div");
      message.classList.add("message", type);
      message.textContent = text;
      chatMessages.appendChild(message);
      chatMessages.scrollTop = chatMessages.scrollHeight;
    }
  });
  