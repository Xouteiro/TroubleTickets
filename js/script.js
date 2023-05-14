const checkbox = document.getElementById('show-department-tickets');
const tickets = document.querySelectorAll('.unassigned-tickets .ticket');
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
            document.querySelector('.unassigned-tickets').appendChild(p);
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
const button = document.getElementById('add-hashtag');


if (newHashtag && button) {
  button.addEventListener('click', function () {
    const hashtagName = newHashtag.value;
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
        const el = document.createElement('button');
        el.classList.add('remove-hashtag');
        el.setAttribute('data-name', response.hashtag_id);
        el.innerHTML = hashtagName + ' &#10006;';
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
  })
}


