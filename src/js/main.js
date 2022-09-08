"use strict";
const openModalClassList = document.querySelectorAll(".modal-open");
const closeModalClassList = document.querySelectorAll(".modal-close");
const overlay = document.querySelector(".modal-overlay");
const body = document.querySelector("body");
const modal = document.querySelector(".modal");
const modalInnerHTML = document.getElementById("modalInner");

for (let i = 0; i < openModalClassList.length; i++) {
  openModalClassList[i].addEventListener(
    "click",
    (e) => {
      e.preventDefault();
      let number = e.currentTarget.id.indexOf("+");
      let eventId = e.currentTarget.id.substring(0, number);
      let userId = e.currentTarget.id.substring(number + 1);
      openModal(eventId, userId);
    },
    false
  );
}

for (var i = 0; i < closeModalClassList.length; i++) {
  closeModalClassList[i].addEventListener("click", closeModal);
}

overlay.addEventListener("click", closeModal);

async function openModal(eventId, userId) {
  try {
    const url =
      "/api/getModalInfo.php?eventId=" + eventId + "&userId=" + userId;
    const res = await fetch(url);
    const event = await res.json();
    let modalHTML = `
    <h2 class="text-md font-bold mb-3">${event.name}</h2>
      <p class="text-sm">${event.date}（${event.day_of_week}）</p>
      <p class="text-sm">${event.start_at} ~ ${event.end_at}</p>

      <hr class="my-4">
      
      <p class="text-md">
      ${event.message}
      
      </p>
      
      <hr class="my-4">
      
      <div class="accordion">
        <div class="option">
          <input type="checkbox" id="toggle1" class="toggle">
          <label class="title" for="toggle1"> <p class="text-sm"><span class="text-xl">${event.sum}</span>人参加 ></p></label>
          <div class="content">
            <p>${event.member}</p>
          </div>
        </div>
      </div>



      <style>
      .accordion {
margin: 3em auto;
max-width: 60vw;
}
.toggle {
display: none;
}
.option {
position: relative;
margin-bottom: 1em;
}
.title,
.content {
-webkit-backface-visibility: hidden;
backface-visibility: hidden;
transform: translateZ(0);
transition: all 0.3s;
}
.title {
border: solid 1px #ccc;
padding: 1em;
display: block;
color: #333;
font-weight: bold;
}
.title::after,
.title::before {
content: "";
position: absolute;
right: 1.25em;
top: 1.25em;
width: 2px;
height: 0.75em;
background-color: #999;
transition: all 0.3s;
}
.title::after {
transform: rotate(90deg);
}
.content {
max-height: 0;
overflow: hidden;
}
.content p {
margin: 0;
padding: 0.5em 1em 1em;
font-size: 0.9em;
line-height: 1.5;
}
.toggle:checked + .title + .content {
max-height: 500px;
transition: all 1.5s;
}
.toggle:checked + .title::before {
transform: rotate(90deg) !important;
}
      </style>



      `;
    console.log(event.status);
    switch (Number(event.status)) {
      case 0:
        modalHTML += `
          <div class="text-center mt-6">
            <p class="text-lg font-bold text-yellow-400">未回答</p>
            <p class="text-xs text-yellow-400">期限 ${event.deadline}</p>
          </div>
          <div class="flex mt-5">
            <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId}, ${userId}, 1)">参加する</button>
            <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId}, ${userId}, 2)">参加しない</button>
        </div>
        `;
        break;
      case 1:
        modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-green-300">参加</p>
          </div>
          <div class="flex mt-5">
          <button class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold">参加する</button>
          <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId}, ${userId}, 2)">参加しない</button>
        </div>
        `;
        break;
      case 2:
        modalHTML += `
          <div class="text-center mt-10">
            <p class="text-xl font-bold text-gray-400">不参加</p>
          </div>
          <div class="flex mt-5">
            <button class="flex-1 bg-gray-300 py-2 mx-3 rounded-3xl text-white text-lg font-bold" onclick="participateEvent(${eventId}, ${userId}, 1)">参加する</button>
            <button class="flex-1 bg-blue-500 py-2 mx-3 rounded-3xl text-white text-lg font-bold">参加しない</button>
        </div>
        `;
        break;
    }
    modalInnerHTML.insertAdjacentHTML("afterbegin", modalHTML);
  } catch (error) {
    console.log(error);
  }
  toggleModal();
}

function closeModal() {
  modalInnerHTML.innerHTML = "";
  toggleModal();
}

function toggleModal() {
  modal.classList.toggle("opacity-0");
  modal.classList.toggle("pointer-events-none");
  body.classList.toggle("modal-active");
}

async function participateEvent(eventId, userId, status) {
  try {
    let formData = new FormData();
    formData.append("eventId", eventId);
    formData.append("userId", userId);
    formData.append("status", status);
    const url = "/api/postEventAttendance.php";
    await fetch(url, {
      method: "POST",
      body: formData,
    }).then((res) => {
      if (res.status !== 200) {
        throw new Error("system error");
      }
      return res.text();
    });
    closeModal();
    location.reload();
  } catch (error) {
    console.log(error);
  }
}
