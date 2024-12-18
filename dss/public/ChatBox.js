import React, { useState, useRef, useEffect } from 'react';

function ChatBox() {
  const [messages, setMessages] = useState([
    {
      id: 1,
      text: "Xin chào! Tôi là trợ lý hỗ trợ. Bạn cần giúp gì?",
      sender: 'bot'
    }
  ]);
  const [inputMessage, setInputMessage] = useState('');
  const [isChatOpen, setIsChatOpen] = useState(false);

  const handleSendMessage = () => {
    if (inputMessage.trim() === '') return;

    const userMessage = {
      id: messages.length + 1,
      text: inputMessage,
      sender: 'user'
    };
    setMessages([...messages, userMessage]);

    // Gửi tin nhắn đến server PHP để xử lý
    fetch('process_chat.php', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
      },
      body: JSON.stringify({ message: inputMessage })
    })
    .then(response => response.json())
    .then(data => {
      const botResponse = {
        id: messages.length + 2,
        text: data.response,
        sender: 'bot'
      };
      setMessages(prevMessages => [...prevMessages, botResponse]);
    });

    setInputMessage('');
  };

  return (
    <div className="chat-container">
      <button onClick={() => setIsChatOpen(!isChatOpen)}>
        {isChatOpen ? 'Đóng Chat' : 'Mở Chat'}
      </button>

      {isChatOpen && (
        <div className="chat-box">
          <div className="messages">
            {messages.map((msg) => (
              <div key={msg.id} className={`message ${msg.sender}`}>
                {msg.text}
              </div>
            ))}
          </div>
          <div className="input-area">
            <input 
              type="text"
              value={inputMessage}
              onChange={(e) => setInputMessage(e.target.value)}
              onKeyPress={(e) => e.key === 'Enter' && handleSendMessage()}
              placeholder="Nhập tin nhắn..."
            />
            <button onClick={handleSendMessage}>Gửi</button>
          </div>
        </div>
      )}
    </div>
  );
}

export default ChatBox;