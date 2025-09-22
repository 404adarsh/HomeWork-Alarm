// const sendMessage = () => {
//   const messageInput = document.getElementById("message-input");
//   const message = messageInput.value.trim();
//   if (message) {
//     // Create a new message div
//     const messageDiv = document.createElement("div");
//     messageDiv.className = "message sent-message";
//     messageDiv.textContent = message;

//     // Clear the message input
//     messageInput.value = "";

//     // Append the message to the sent message container
//     const sentMessageContainer = document.getElementById("sent-message-container");
//     sentMessageContainer.appendChild(messageDiv);

//     // Send the message to the server using AJAX
//     const xhr = new XMLHttpRequest();
//     xhr.open("POST", "chat.php", true);
//     xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
//     xhr.onload = () => {
//       if (xhr.status === 200) {
//         console.log(xhr.responseText);
//       }
//     };
//     xhr.send(`message=${encodeURIComponent(message)}`);
//   }
// };

// const messageInput = document.getElementById("message-input");
// messageInput.addEventListener("keydown", (event) => {
//   if (event.key === "Enter") {
//     sendMessage();
//     event.preventDefault();
//   }
// });

// const sendButton = document.getElementById("send-button");
// sendButton.addEventListener("click", sendMessage);