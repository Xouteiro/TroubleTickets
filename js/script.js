const checkbox = document.getElementById('show-department-tickets');
const tickets = document.querySelectorAll('#unassigned-tickets .ticket');
const p = document.createElement('p');
p.textContent = 'No tickets here yet!';



if (checkbox && tickets && p) {
  checkbox.addEventListener('change', function () {
    let flag = 0;
    p.remove();

    if (this.checked) {
      const h3 = document.querySelector('h3[data-agent-dep]');
      const agentDep = h3.getAttribute('data-agent-dep');
      for (let i = 0; i < tickets.length; i++) {
        const h5 = tickets[i].querySelector('h5[data-ticket-dep]');
        const ticketDep = h5.getAttribute('data-ticket-dep');
        console.log(ticketDep);
        if (ticketDep === agentDep) {
          tickets[i].style.display = 'flex';
          flag = 1;
        } else {
          tickets[i].style.display = 'none';
        }
      }
    } else {
      for (let i = 0; i < tickets.length; i++) {
        tickets[i].style.display = 'flex';
        flag = 1;
      }
    }

    if (flag === 0) {
      document.getElementById('unassigned-tickets').appendChild(p);
    }
  })
}


const removeButtons = document.querySelectorAll('.remove-hashtag');

if (removeButtons) {
  removeButtons.forEach(button => {
    button.addEventListener('click', function () {

      var hashtagId = button.getAttribute("data-name");
      var ticketId = document.querySelector("h3[data-ticketid]").getAttribute("data-ticketid");
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "../actions/action_remove_hashtag.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.send("ticket_id=" + encodeURIComponent(ticketId) + "&hashtag_id=" + encodeURIComponent(hashtagId));
      button.remove();
    })
  })
}

const newHashtag = document.getElementById('new-hashtag');

if (newHashtag) {
  newHashtag.addEventListener('keyup', function (event) {
    if (event.key === 'Enter') {
      let hashtagName = newHashtag.value;
      hashtagName = hashtagName.replace(/#/g, ''); 
      if (!hashtagName.startsWith('#')) {
        hashtagName = '#' + hashtagName; 
      }
      const ticketId = document.querySelector('h3[data-ticketid]').getAttribute('data-ticketid');
      const xhr = new XMLHttpRequest();
      xhr.open('POST', '../actions/action_add_hashtag.php', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send('ticket_id=' + encodeURIComponent(ticketId) + '&hashtag_name=' + encodeURIComponent(hashtagName));

      xhr.addEventListener('load', function () {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);
          console.log(response);
          if (response.hashtag_id == "0") {
            newHashtag.value = '';
            return;
          }
          const el = document.createElement('input');
          el.setAttribute('type', 'button');
          el.classList.add('remove-hashtag');
          el.setAttribute('data-name', response.hashtag_id);
          el.value = hashtagName + ' \u2716';
          el.addEventListener('click', function () {
            const hashtagId = this.getAttribute('data-name');
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '../actions/action_remove_hashtag.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('ticket_id=' + encodeURIComponent(ticketId) + '&hashtag_id=' + encodeURIComponent(hashtagId));
            this.remove();
          });
          document.querySelector('.hashtags').append(el);
          newHashtag.value = '';
        }
      })
    }
  })
}

const departments = document.querySelectorAll('.departments h3[data-dep-id]');

if (departments) {
  const faqs = document.querySelectorAll('.questions div[data-faq-id]');
  departments.forEach(dep => {
    dep.addEventListener('click', function () {
      const depId = dep.getAttribute('data-dep-id');
      if (depId != 0) {
        faqs.forEach(faq => {
          const faqId = faq.getAttribute('data-faq-id');
          if (depId != faqId) {
            faq.style.display = 'none';
          }
          if (depId == faqId) {
            faq.style.display = 'flex';
            faq.style.flexDirection = 'column';
          }
        })
      } else if (depId == 0) {
        faqs.forEach(faq => {
          faq.style.display = 'flex';
          faq.style.flexDirection = 'column';
        })
      }
    })
  })
}




function resizeInput(input) {
  input.style.width = 7 + input.value.length + "ch";
}

if (newHashtag) {
  resizeInput(newHashtag);
  newHashtag.addEventListener('keyup', function () {
    resizeInput(this);
  })
}

document.addEventListener('click', function (event) {
  const target = event.target;
  if (target.classList.contains('slide-button')) {
    const ticketsContainer = target.closest('.tickets-container').querySelector('.tickets');
    if (target.classList.contains('left')) {
      ticketsContainer.scrollBy({ left: -350, behavior: 'smooth' });
    } else if (target.classList.contains('right')) {
      ticketsContainer.scrollBy({ left: 350, behavior: 'smooth' });
    }
    toggleSlideButtons(ticketsContainer);
  }
});

function toggleSlideButtons(ticketsContainer) {
  const leftButton = ticketsContainer.parentElement.querySelector('.left');
  const rightButton = ticketsContainer.parentElement.querySelector('.right');

  if (ticketsContainer.scrollLeft === 0) {
    leftButton.style.display = 'none';
  } else {
    leftButton.style.display = 'block';
  }

  if (ticketsContainer.scrollLeft + ticketsContainer.clientWidth >= ticketsContainer.scrollWidth) {
    rightButton.style.display = 'none';
  } else {
    rightButton.style.display = 'block';
  }
}

const sendMessage = document.querySelector("#send");
if (sendMessage) {
  sendMessage.addEventListener('click', async function (event) {
    event.preventDefault();
    const text = document.querySelector("#message").value;
    console.log(text);
    const ticketId = document.querySelector("#ticket_id").value;
    const userId = document.querySelector("#user_id").value;
    const username = document.querySelector("#username").value;
    const clientId = document.querySelector("#client_id").value;
    const agentId = document.querySelector("#agent_id").value;

    try {
      const response = await fetch("../actions/action_send_message.php", {
        method: 'POST',
        headers: {
          'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams({ ticket_id: ticketId, user_id: userId, username: username, client_id: clientId, agent_id: agentId, message: text })
      });

      if (response.ok) {
        const data = await response.json();

        if (data.status === "success") {
          if (userId == agentId || (userId != clientId && agentId == 0)) {
            const placeToInsert = document.querySelector(".text");
            const agentMessageDiv = document.createElement('div');
            agentMessageDiv.classList.add('agent-message');
            const fullLineDiv = document.createElement('div');
            fullLineDiv.classList.add('full-line');
            agentMessageDiv.appendChild(fullLineDiv);
            const agentHeader = document.createElement('h4');
            agentHeader.textContent = 'Agent:';
            fullLineDiv.appendChild(agentHeader);
            const agentName = document.createElement('h4');
            agentName.innerHTML = data.username; 
            fullLineDiv.appendChild(agentName);
            const messageContent = document.createElement('p');
            messageContent.textContent = text; 
            agentMessageDiv.appendChild(messageContent);
            const messageDate = document.createElement('h5');
            messageDate.textContent = 'Just now'; 
            agentMessageDiv.appendChild(messageDate);
            placeToInsert.appendChild(agentMessageDiv);
            agentMessageDiv.style.opacity = 0; 

            setTimeout(() => {
              agentMessageDiv.style.opacity = 1;
              agentMessageDiv.scrollIntoView({ behavior: 'smooth', block: 'end' });
            }, 10)
            
          } else if (userId == clientId) {
            const placeToInsert = document.querySelector(".text");
            const clientMessageDiv = document.createElement('div');
            clientMessageDiv.classList.add('client-message');
            const fullLineDiv = document.createElement('div');
            fullLineDiv.classList.add('full-line');
            clientMessageDiv.appendChild(fullLineDiv);
            const clientHeader = document.createElement('h4');
            clientHeader.textContent = 'Client:';
            fullLineDiv.appendChild(clientHeader);
            const clientName = document.createElement('h4');
            clientName.innerHTML = data.username; 
            fullLineDiv.appendChild(clientName);
            const messageContent = document.createElement('p');
            messageContent.textContent = text; 
            clientMessageDiv.appendChild(messageContent);
            const messageDate = document.createElement('h5');
            messageDate.textContent = 'Just now';
            clientMessageDiv.appendChild(messageDate);
            placeToInsert.appendChild(clientMessageDiv);
            clientMessageDiv.style.opacity = 0;

            setTimeout(() => {
              clientMessageDiv.style.opacity = 1;
              clientMessageDiv.scrollIntoView({ behavior: 'smooth', block: 'end' });
            }, 10);
          }
        }
        
      }
    } catch (error) {
      console.error('Error sending message:', error);
    }
  })
}


function encodeForAjax(data) {
  return Object.keys(data).map(function(k){
    return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
  }).join('&')
}


// Get the image containers
const steps = document.querySelectorAll('.step');
let currentStepIndex = 0;

if(steps) {
steps[currentStepIndex].classList.add('active');
const interval = 5000;
setInterval(showNextStep, interval);
}

function showNextStep() {
  steps[currentStepIndex].classList.remove('active');
  steps[currentStepIndex].classList.add('slide-out');
  currentStepIndex = (currentStepIndex + 1) % steps.length;
  steps[currentStepIndex].classList.add('active');
  steps[currentStepIndex].classList.remove('slide-out');
}