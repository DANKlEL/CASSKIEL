const chatbox = document.getElementById("chatbox");
const userInput = document.getElementById("userInput");
const sendButton = document.getElementById("sendButton");
const avatar = document.getElementById("avatar");
const chatContainer = document.getElementById("chatContainer");
const chatIcon = document.getElementById("chatIcon");

let selectedVoice = null;
let optionsShown = false;  

function getVoices() {
  const voices = speechSynthesis.getVoices();
  selectedVoice = voices.find(voice => voice.name.toLowerCase().includes("pablo"));
}

speechSynthesis.onvoiceschanged = getVoices;

function addMessage(text, sender) {
  const message = document.createElement("div");
  message.classList.add("message", sender);
  message.textContent = text;
  chatbox.appendChild(message);
  chatbox.scrollTop = chatbox.scrollHeight;
}

function speak(text) {
  if (selectedVoice) {
    const utterance = new SpeechSynthesisUtterance(text);
    utterance.voice = selectedVoice;
    utterance.lang = "es-ES";
    avatar.play();
    speechSynthesis.speak(utterance);
    utterance.onend = function () {
      avatar.pause();
      if (!optionsShown) {
        showOptions();
      }
    };
  } else {
    console.log("Voz masculina no encontrada.");
  }
}

function showOptions() {
  if (!optionsShown) { 
    const optionsDiv = document.createElement("div");
    optionsDiv.classList.add("options");

    const option1 = document.createElement("button");
    option1.classList.add("option-button");
    option1.textContent = "Productos recomendados";
    option1.onclick = () => redirectToOptionChat("productos");

    const option2 = document.createElement("button");
    option2.classList.add("option-button");
    option2.textContent = "Consultar disponibilidad";
    option2.onclick = () => redirectToOptionChat("disponibilidad");

    const option3 = document.createElement("button");
    option3.classList.add("option-button");
    option3.textContent = "Promociones o descuentos";
    option3.onclick = () => redirectToOptionChat("promociones");

    const option4 = document.createElement("button");
    option4.classList.add("option-button");
    option4.textContent = "Métodos de pago";
    option4.onclick = () => redirectToOptionChat("pago");

    const option5 = document.createElement("button");
    option5.classList.add("option-button");
    option5.textContent = "Preguntas frecuentes";
    option5.onclick = () => redirectToOptionChat("preguntas");

    optionsDiv.appendChild(option1);
    optionsDiv.appendChild(option2);
    optionsDiv.appendChild(option3);
    optionsDiv.appendChild(option4);
    optionsDiv.appendChild(option5);

    chatbox.appendChild(optionsDiv);
    optionsShown = true;  
  }
}

function redirectToOptionChat(option) {
  const optionsDiv = document.querySelector(".options");
  if (optionsDiv) optionsDiv.remove(); 
  let response = "";
  switch(option) {
    case "productos":
      response = "¡Bienvenido! Los productos favoritos de perros y gatos te esperan. ¿Qué accesorio buscas hoy?";
      break;
    case "disponibilidad":
      response = "¿El producto es para perros o gatos? Puedo verificar la disponibilidad para ti.";
      break;
    case "promociones":
      response = "En MAYA tenemos varias promociones y descuentos. ¿Te interesa saber promociones o descuentos?";
      break;
    case "pago":
      response = "¡Claro! Te ayudo con eso. ¿Cómo te gustaría pagar? Te puedo decir qué métodos de pago tenemos disponibles";
      break;
    case "preguntas":
      response = "¡Bienvenido! Estás en nuestra sección de preguntas frecuentes, donde podrás encontrar respuestas rápidas a tus dudas";
      break;
    default:
      response = "Lo siento, no entiendo esa opción.";
  }

  chatbox.innerHTML = "";  
  addMessage(response, "ai");
  speak(response);

  if (option === "preguntas") {
    showFAQOptions();  
  }

  if (option === "productos") {
    showProductOptions(); 
  }
}

function showProductOptions() {
  const productOptionsDiv = document.createElement("div");
  productOptionsDiv.classList.add("product-options");

  const juguetesButton = document.createElement("button");
  juguetesButton.classList.add("product-button");
  juguetesButton.textContent = "Juguetes de mascotas";
  juguetesButton.onclick = () => showProducts("juguetes");

  const collaresButton = document.createElement("button");
  collaresButton.classList.add("product-button");
  collaresButton.textContent = "Collares de mascotas";
  collaresButton.onclick = () => showProducts("collares");

  const favoritosDePerrosButton = document.createElement("button");
  favoritosDePerrosButton.classList.add("product-button");
  favoritosDePerrosButton.textContent = "Favoritos de perros";
  favoritosDePerrosButton.onclick = () => showProducts("favoritos de perros");

  const favoritosDeGatosButton = document.createElement("button");
  favoritosDeGatosButton.classList.add("product-button");
  favoritosDeGatosButton.textContent = "Favoritos de gatos";
  favoritosDeGatosButton.onclick = () => showProducts("favoritos de gatos");

  productOptionsDiv.appendChild(juguetesButton);
  productOptionsDiv.appendChild(collaresButton);
  productOptionsDiv.appendChild(favoritosDePerrosButton);
  productOptionsDiv.appendChild(favoritosDeGatosButton);

  chatbox.appendChild(productOptionsDiv);
}

function showProducts(category) {
  let productResponse = "";
  let productsHTML = "";

  if (category === "juguetes") {
    productResponse = "Descubre los juguetes más queridos por perros y gatos:";
    productsHTML = `
      <div class="product">
        <img src="imagen7.jpg" alt="jugueteperro" />
        <p>Hueso de juguete - $169</p>
        <button onclick="addToCart('Hueso de juguete', 169)">Añadir al carrito</button>
      </div>
      <div class="product">
        <img src="imagen9.jpg" alt="juguetegato" />
        <p>Juguete ratón - $60</p>
        <button onclick="addToCart('Juguete raton', 60)">Añadir al carrito</button>
      </div>
    `;
  } else if (category === "collares") {
    productResponse = "Explora los collares favoritos de perros y gatos:";
    productsHTML = `
      <div class="product">
        <img src="imagen10.jpg" alt="Collar para perro" />
        <p>Collar para perro - $450</p>
        <button onclick="addToCart('Collar para perro', 100)">Añadir al carrito</button>
      </div>
      <div class="product">
        <img src="imagen4.jpg" alt="Collar corbata" />
        <p>Collar corbata - $150</p>
        <button onclick="addToCart('Collar corbata', 150)">Añadir al carrito</button>
      </div>
    `;
  } else if (category === "favoritos de perros") {
    productResponse = "Estos son algunos accesorios favoritos de perros:";
    productsHTML = `
      <div class="product">
        <img src="imagen6.jpg" alt="Chaleco para perro" />
        <p>Chaleco - $200</p>
        <button onclick="addToCart('Chaleco para perro', 200)">Añadir al carrito</button>
      </div>
      <div class="product">
        <img src="imagen11.jpg" alt="Croquetas para perro" />
        <p>Croquetas para perro - $150</p>
        <button onclick="addToCart('Croquetas para perro', 150)">Añadir al carrito</button>
      </div>
    `;
  } else if (category === "favoritos de gatos") {
    productResponse = "Descubre los productos favoritos de los gatos:";
    productsHTML = `
      <div class="product">
        <img src="imagen2.jpg" alt="Casa para dormir" />
        <p>Casa para dormir - $600</p>
        <button onclick="addToCart('Casa para dormir', 200)">Añadir al carrito</button>
      </div>
      <div class="product">
        <img src="imagen3.jpg" alt="Collar para gato" />
        <p>Collar - $200</p>
        <button onclick="addToCart('Collar', 1600)">Añadir al carrito</button>
      </div>
    `;
  }

  chatbox.innerHTML = "";  
  addMessage(productResponse, "ai");
  chatbox.innerHTML += productsHTML;

  const seeAnotherButton = document.createElement("button");
  seeAnotherButton.classList.add("product-button");
  seeAnotherButton.textContent = "¿Te gustaría ver otro producto?";
  seeAnotherButton.onclick = () => showProductOptions(); 

  chatbox.appendChild(seeAnotherButton);
  speak(productResponse);
}

function addToCart(productName, price) {
  carrito.push({ name: productName, price: price });
  alert(`${productName} ha sido añadido a tu carrito por $${price}.`);  
  showCart();
}

function showCart() {
  let cartHTML = "<h3>Tu carrito:</h3>";

  if (carrito.length > 0) {
    carrito.forEach(item => {
      cartHTML += `
        <div class="cart-item">
          <p>${item.name} - $${item.price}</p>
        </div>
      `;
    });
  } else {
    cartHTML += "<p>Tu carrito está vacío.</p>";
  }

  let total = carrito.reduce((acc, item) => acc + item.price, 0);
  cartHTML += `<p>Total: $${total}</p>`;
  
  const checkoutButton = document.createElement("button");
  checkoutButton.classList.add("product-button");
  checkoutButton.textContent = "Ir al carrito";
  checkoutButton.onclick = () => {
    alert("Redirigiendo al carrito...");
  };

  chatbox.innerHTML += cartHTML;
  chatbox.appendChild(checkoutButton);
  speak("Tu carrito ha sido actualizado.");
}

function showFAQOptions() {
  const faqOptionsDiv = document.createElement("div");
  faqOptionsDiv.classList.add("faq-options");

  const faq1 = document.createElement("button");
  faq1.classList.add("faq-button");
  faq1.textContent = "¿Y si mi pedido llegó dañado?";
  faq1.onclick = () => showFAQAnswer("pedidoDañado");

  const faq2 = document.createElement("button");
  faq2.classList.add("faq-button");
  faq2.textContent = "¿Si el producto no está disponible?";
  faq2.onclick = () => showFAQAnswer("productoNoDisponible");

  const faq3 = document.createElement("button");
  faq3.classList.add("faq-button");
  faq3.textContent = "¿Cómo puedo devolver un producto?";
  faq3.onclick = () => showFAQAnswer("devolverProducto");

  const faq4 = document.createElement("button");
  faq4.classList.add("faq-button");
  faq4.textContent = "¿Cuánto cuesta el envío?";
  faq4.onclick = () => showFAQAnswer("costoEnvio");

  const faq5 = document.createElement("button");
  faq5.classList.add("faq-button");
  faq5.textContent = "¿Cuál es su contacto?";
  faq5.onclick = () => showFAQAnswer("contacto");

  const faq6 = document.createElement("button");
  faq6.classList.add("faq-button");
  faq6.textContent = "Tengo problemas al pagar";
  faq6.onclick = () => showFAQAnswer("problemasPago");

  faqOptionsDiv.appendChild(faq1);
  faqOptionsDiv.appendChild(faq2);
  faqOptionsDiv.appendChild(faq3);
  faqOptionsDiv.appendChild(faq4);
  faqOptionsDiv.appendChild(faq5);
  faqOptionsDiv.appendChild(faq6);

  chatbox.appendChild(faqOptionsDiv);
}

function showFAQAnswer(faq) {
  let answer = "";

  switch(faq) {
    case "pedidoDañado":
      answer = "Si tu pedido llegó dañado, por favor contáctanos dentro de las primeras 48 horas a nuestro correo o número. Estaremos encantados de ayudarte con un reemplazo o reembolso.";
      break;
    case "productoNoDisponible":
      answer = "Si el producto que deseas no está disponible, puedes unirte a nuestra lista de espera";
      break;
    case "devolverProducto":
      answer = "Puedes solicitar la devolución de un producto dentro de los 15 días posteriores a la compra. Solo contáctanos y te guiaremos durante el proceso.";
      break;
    case "costoEnvio":
      answer = "El costo del envío depende de tu ubicación. Verás el precio exacto al finalizar la compra, antes de realizar el pago.";
      break;
    case "contacto":
      answer = "Puedes contactarnos por correo electrónico a: SoporteAccsMaya@outlook.com";
      break;
    case "problemasPago":
      answer = "Si tienes problemas con el pago, verifica los datos de tu tarjeta o prueba otro método de pago. Si el problema persiste, contáctanos y estaremos encantados de ayudarte.";
      break;
    default:
      answer = "Lo siento, no tengo información sobre eso.";
  }

  chatbox.innerHTML = "";  
  addMessage(answer, "ai");
  speak(answer);
}

let lastCategory = ""; 

function processAIResponse(userInput) {
  let response = "Lo siento, no entendí eso";
  const lowerInput = userInput.toLowerCase();

  if (lowerInput.includes("hola")) {
    response = "¡Hola! Soy Carlos, tu asistente virtual de MAYA. ¿En qué puedo ayudarte hoy?";
    lastCategory = ""; 
  } 
  else if (lowerInput.includes("perros")) {
    lastCategory = "perros"; 
    response = "Todos los productos para perros están disponibles. ¿Hay algún producto que te gustaría confirmar si está disponible?";
  } else if (lowerInput.includes("gatos")) {
    lastCategory = "gatos"; 
    response = "Todos los productos de gatos están disponibles. ¿Hay algún producto que te gustaría confirmar si está disponible?";
  } else if (lastCategory === "perros") {
    if (lowerInput.includes("camas")) {
      response = "¡Sí, contamos con camas para perros en varios tamaños y colores!";
    } else if (lowerInput.includes("collares")) {
      response = "También tenemos collares disponibles en diferentes diseños";
    } else if (lowerInput.includes("juguetes")) {
      response = "Sí, contamos con una gran variedad de juguetes disponibles para perros";
    } else if (lowerInput.includes("ropa")) {
      response = "Sí, contamos con una variedad de ropa disponible para perros";
    } else if (lowerInput.includes("croquetas")) {
      response = "Sí, contamos con croquetas disponible para perros";
    } else if (lowerInput.includes("gracias") || lowerInput.includes("okey") || lowerInput.includes("ok")) {
      response = "¡Perfecto! Si necesitas algo más, no dudes en decirme";
    } 
  } else if (lastCategory === "gatos") {
    if (lowerInput.includes("juguetes")) {
      response = "¡Claro! Contamos con una variedad de juguetes para gatos, como pelotas y juguete ratón";
    } else if (lowerInput.includes("rascadores")) {
      response = "¡Sí, tenemos rascadores disponibles en varios tamaños y estilos!";
    } else if (lowerInput.includes("bebederos")) {
      response = "También tenemos bebederos disponibles.";
    } else if (lowerInput.includes("ropa")) {
      response = "Sí, hay una variedad extensa de ropa disponible para gatos.";
    } else if (lowerInput.includes("gracias") || lowerInput.includes("okey") || lowerInput.includes("ok")) {
      response = "¡Por supuesto! Si necesitas algo más, estaré aquí para ayudarte";
    }
  } else if (lowerInput.includes("metodos de pago")) {
    lastCategory = "metodos de pago"; 
    response = "Aceptamos tarjetas Visa, MasterCard y American Express, así como PayPal. ¿Te gustaría saber más?";
  } else if (lastCategory === "metodos de pago") {
    if (lowerInput.includes("tarjetas")) {
      response = "Aceptamos tarjetas Visa, MasterCard y American Express. ¿Te gustaría saber más?";
    } else if (lowerInput.includes("paypal")) {
      response = "Sí, aceptamos PayPal y tarjetas. ¿Te puedo ayudar con algo más?";
    } else if (lowerInput.includes("transferencia")) {
      response = "No aceptamos transferencias, pero puedes pagar con tarjeta o PayPal";
    } else if (lowerInput.includes("efectivo")) {
      response = "Solo aceptamos pagos en línea con tarjeta o PayPal";
    } else if (lowerInput.includes("plazos")) {
      response = "No ofrecemos pagos a plazos, pero puedes pagar con tarjeta o PayPal";
    } else if (lowerInput.includes("gracias") || lowerInput.includes("okey") || lowerInput.includes("No")) {
      response = "¡Por supuesto! Si necesitas algo más, estaré aquí para ayudarte";
    }
  } else if (lowerInput.includes("tarjetas") || lowerInput.includes("paypal") || lowerInput.includes("transferencia") || lowerInput.includes("efectivo") || lowerInput.includes("plazos")) {
    if (lowerInput.includes("tarjetas")) {
      response = "Aceptamos tarjetas Visa, MasterCard y American Express. ¿Te gustaría saber más?";
    } else if (lowerInput.includes("paypal")) {
      response = "Sí, aceptamos PayPal y tarjetas. ¿Te puedo ayudar con algo más?";
    } else if (lowerInput.includes("transferencia")) {
      response = "No aceptamos transferencias, pero puedes pagar con tarjeta o PayPal";
    } else if (lowerInput.includes("efectivo")) {
      response = "Solo aceptamos pagos en línea con tarjeta o PayPal";
    } else if (lowerInput.includes("plazos")) {
      response = "No ofrecemos pagos a plazos, pero puedes pagar con tarjeta o PayPal";
    } else if (lowerInput.includes("gracias") || lowerInput.includes("okey") || lowerInput.includes("No, gracias")) {
      response = "¡Por supuesto! Si necesitas algo más, estaré aquí para ayudarte";
    }
  }

  if (lowerInput.includes("descuentos")) {
    response = "Tenemos 2 ofertas: una del 15% y otra del 30%. ¿Cuál te interesa?";
  } else if (lowerInput.includes("15%")) {
    response = "¡Aprovecha ahora! Obtén un 15% de descuento en tu compra utilizando el código: MAYA15. ¡Tu mascota lo agradecerá!";
  } else if (lowerInput.includes("30%")) {
    response = "¡Es tu oportunidad! 30% de descuento en los productos de gatos con el código: MAYA30. ¡Haz feliz a tu gatito!";
  } else if (lowerInput.includes("gracias") || lowerInput.includes("okey") || lowerInput.includes("No")) {
    response = "¡Por supuesto! Si necesitas algo más, estaré aquí para ayudarte.";
  }  

  if (lowerInput.includes("promociones")) {
    response = "¡Tenemos 2 increíbles promociones para ti!: 3x1 y producto gratis. ¿Cuál te gustaría aprovechar?";
  } else if (lowerInput.includes("3x1")) {
    response = "¡3x1 en MAYA!. Unicamente en juguetes de gatos. Usa el código MAYA3X1.";
  } else if (lowerInput.includes("producto gratis")) {
    response = "Compra en MAYA y recibe un producto gratis con el código MAYAGIFT. ¡Solo por tiempo limitado!";
  } else if (lowerInput.includes("gracias") || lowerInput.includes("okey") || lowerInput.includes("No")) {
    response = "¡Por supuesto! Si necesitas algo más, estaré aquí para ayudarte.";
  }  
  
  else if (lowerInput.includes("correo") || lowerInput.includes("contacto") || lowerInput.includes("contactar")) {
    response = "Correo: SoporteAccsMaya@outlook.com";
  }  
  else if (lowerInput.includes("número") || lowerInput.includes("telefono")) {
    response = "Número: 55 49 20 18 63";
  }  
  else if (lowerInput.includes("celular")) {
    response = "Número: 55 49 20 18 63";
  }  
  else if (lowerInput.includes("lista de espera") || lowerInput.includes("lista")) {
    response = "Envíanos un correo a para agregarte a la lista de espera y te avisaremos cuando el producto esté disponible";
  } if (lowerInput.includes("hola")) {
    response = "¡Hola! Soy Carlos, tu asistente virtual de MAYA. ¿En qué puedo ayudarte hoy?";
    lastCategory = ""; 
  } else if (lowerInput.includes("paypal")) {
    response = "Sí, aceptamos PayPal y tarjetas. ¿Te puedo ayudar con algo más?";
  } else if (lowerInput.includes("transferencia")) {
    response = "No aceptamos transferencias, pero puedes pagar con tarjeta o PayPal";
  } else if (lowerInput.includes("efectivo")) {
    response = "Solo aceptamos pagos en línea con tarjeta o PayPal";
  } else if (lowerInput.includes("plazos")) {
    response = "No ofrecemos pagos a plazos, pero puedes pagar con tarjeta o PayPal";
  } else if (lowerInput.includes("gracias") || lowerInput.includes("No") || lowerInput.includes("No, gracias")) {
    response = "¡Por supuesto! Si necesitas algo más, estaré aquí para ayudarte";
  } else if (lowerInput.includes("metodos de pago") || lowerInput.includes("métodos de pago")) {
    response = "Aceptamos tarjetas Visa, MasterCard y American Express, así como PayPal. ¿Te gustaría saber más?"; 
  } else if (lowerInput.includes("tarjetas")) {
    response = "Aceptamos tarjetas Visa, MasterCard y American Express. ¿Te gustaría saber más?";
  } if (lowerInput.includes("menú") || lowerInput.includes("ayuda")) {
    response = "¡Claro! Aquí tienes el menú de opciones para que puedas elegir:";
    optionsShown = false; 
    showOptions();  
  } 

  addMessage(response, "ai");
  speak(response);
}

sendButton.addEventListener("click", () => {
  const userText = userInput.value.trim();
  if (userText === "") return;

  addMessage(userText, "user");
  userInput.value = "";
  processAIResponse(userText);
});

userInput.addEventListener("keypress", (e) => {
  if (e.key === "Enter") {
    sendButton.click();
  }
});

function toggleChat() {
  if (chatContainer.style.display === "none" || chatContainer.style.display === "") {
    chatContainer.style.display = "flex";
    chatIcon.style.display = "none";
    addMessage("¡Hola! Soy Carlos, tu asistente virtual de MAYA. ¿En qué puedo ayudarte hoy?", "ai");
    speak("¡Hola! Soy Carlos, tu asistente virtual de MAYA. ¿En qué puedo ayudarte hoy?");
    optionsShown = false;  
  } else {
    chatContainer.style.display = "none";
    chatIcon.style.display = "block";
  }
}

