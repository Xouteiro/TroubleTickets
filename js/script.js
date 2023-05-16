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
  newHashtag.addEventListener('keyup', function(event) {
    if (event.key === 'Enter') {
      let hashtagName = newHashtag.value;
      hashtagName = hashtagName.replace(/#/g, ''); // remove any "#" symbols except for the first one
      if (!hashtagName.startsWith('#')) {
        hashtagName = '#' + hashtagName; // add the "#" symbol
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
            // Hashtag already exists, don't add it again
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




function resizeInput(input) {
  input.style.width = 7 + input.value.length + "ch";
}

if(newHashtag){
  resizeInput(newHashtag);
  newHashtag.addEventListener('keyup', function () {
    resizeInput(this);
  })
}

document.addEventListener('click', function (event) {
  const target = event.target;
  if (target.classList.contains('slide-button')) {
    const ticketsContainer = target.closest('.tickets-container').querySelector('.tickets');
    if (target.id === 'left') {
      ticketsContainer.scrollBy({ left: -350, behavior: 'smooth' });
    } else if (target.id === 'right') {
      ticketsContainer.scrollBy({ left: 350, behavior: 'smooth' });
    }
    toggleSlideButtons(ticketsContainer);
  }
})

document.addEventListener('click', function (event) {
  const target = event.target;
  if (target.classList.contains('slide-button')) {
    const ticketsContainer = target.closest('.tickets-container').querySelector('.tickets').querySelector('.left');
    if (target.id === 'left') {
      ticketsContainer.scrollBy({ left: -350, behavior: 'smooth' });
    } else if (target.id === 'right') {
      ticketsContainer.scrollBy({ left: 350, behavior: 'smooth' });
    }
    toggleSlideButtons(ticketsContainer);
  }
})

function toggleSlideButtons(ticketsContainer) {
  const leftButton = ticketsContainer.parentElement.querySelector('#left');
  const rightButton = ticketsContainer.parentElement.querySelector('#right');

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
