// =========================
// CEK USER LOGIN
// =========================
let user = JSON.parse(localStorage.getItem("currentUser"));
let notifications = JSON.parse(localStorage.getItem("notifications")) || [];

if (!user) {
  alert("Silakan login dulu!");
  window.location.href = "login.html";
}

// =========================
// TAMPILKAN USER
// =========================
document.addEventListener("DOMContentLoaded", function () {

  let username = document.getElementById("username");

  if (username) {
    username.innerText = user.email;
  }

  let profileData = JSON.parse(localStorage.getItem("profileData"));

  let profileName = document.getElementById("profileName");
  let profileDivision = document.getElementById("profileDivision");
  let profileJob = document.getElementById("profileJob");

  if (profileName) {
    profileName.innerText = profileData?.name || user.email;
  }

  if (profileDivision) {
    profileDivision.innerText = profileData?.division || "Web Developer & Designer";
  }

  if (profileJob) {
    profileJob.innerText = profileData?.job || "Staff Bikin Kreatif";
  }

});

// =========================
// LOGOUT
// =========================
function logout() {
  localStorage.removeItem("currentUser");
  window.location.href = "login.html";
}

// =========================
// TOGGLE DROPDOWN
// =========================
function toggleMenu() {
  let menu = document.getElementById("dropdown");

  menu.style.display =
    (menu.style.display === "block") ? "none" : "block";
}

// =========================
// NAVIGASI MENU
// =========================
function goHome() {
  window.location.href = "dashboard.html";
}

function goProfile() {
  window.location.href = "profile.html";
}

function goEditProfile() {
  window.location.href = "editprofile.html";
}

// =========================
// GROUP MENU
// =========================
function toggleGroupMenu() {

  let menu = document.getElementById("groupDropdown");

  if (!menu) return;

  menu.style.display =
    (menu.style.display === "block")
      ? "none"
      : "block";
}

function openGroup(groupName) {

  localStorage.setItem("currentGroup", groupName);

  window.location.href = "group.html";
}

// =========================
// TAMBAH GRUP (DYNAMIC)
// =========================
let groups = JSON.parse(localStorage.getItem("customGroups")) || [];

function createGroup() {
  document.getElementById("createGroupModal").style.display = "block";
}

function closeCreateGroupModal() {
  document.getElementById("createGroupModal").style.display = "none";
  document.getElementById("columnContainer").innerHTML = "";
  document.getElementById("newGroupName").value = "";
}

function addColumnConfig() {
  let container = document.getElementById("columnContainer");
  let columnDiv = document.createElement("div");
  columnDiv.className = "column-config";
  columnDiv.innerHTML = `
    <span class="remove-column" onclick="this.parentElement.remove()">✖</span>
    <label>Judul Kolom</label>
    <input type="text" class="col-title" placeholder="Contoh: Nama Klien">
    <label>Tipe Kolom</label>
    <select class="col-type">
      <option value="text">Text Input</option>
      <option value="dropdown">Dropdown</option>
      <option value="date">Date Picker</option>
      <option value="file">File Upload</option>
      <option value="url">URL Input</option>
    </select>
    <div class="dropdown-options" style="display:none;">
      <label>Opsi Dropdown (pisahkan dengan koma)</label>
      <input type="text" class="col-options" placeholder="Opsi 1, Opsi 2, Opsi 3">
    </div>
  `;
  
  // Show/hide dropdown options based on selection
  let select = columnDiv.querySelector(".col-type");
  select.onchange = function() {
    let optionsDiv = columnDiv.querySelector(".dropdown-options");
    optionsDiv.style.display = (this.value === "dropdown") ? "block" : "none";
  };
  
  container.appendChild(columnDiv);
}

function saveNewGroup() {
  let groupName = document.getElementById("newGroupName").value.trim();
  if (!groupName) {
    alert("Nama grup harus diisi!");
    return;
  }

  let columnConfigs = document.querySelectorAll(".column-config");
  let columns = [];
  columnConfigs.forEach(config => {
    let title = config.querySelector(".col-title").value.trim();
    let type = config.querySelector(".col-type").value;
    let options = config.querySelector(".col-options") ? config.querySelector(".col-options").value.split(",").map(o => o.trim()) : [];
    
    if (title) {
      columns.push({ title, type, options });
    }
  });

  if (columns.length === 0) {
    alert("Tambahkan setidaknya satu kolom!");
    return;
  }

  let newGroup = {
    name: groupName,
    columns: columns
  };

  groups.push(newGroup);
  localStorage.setItem("customGroups", JSON.stringify(groups));
  
  alert("Grup berhasil dibuat!");
  closeCreateGroupModal();
  renderGroups();
  
  // Buka grup yang baru dibuat
  openGroup(groupName);
}

function renderGroups() {
  let list = document.getElementById("dynamicGroupList");
  if (!list) return;

  // Default groups
  let html = `
    <p onclick="openGroup('Admin')">Admin</p>
    <p onclick="openGroup('Web Developer')">Web Developer</p>
    <p onclick="openGroup('Designer')">Designer</p>
  `;

  // Custom groups
  groups.forEach(g => {
    html += `<p onclick="openGroup('${g.name}')">${g.name}</p>`;
  });

  list.innerHTML = html;
}

// =========================
// AMBIL POST
// =========================
let posts = JSON.parse(localStorage.getItem("posts")) || [];

posts = posts.map(post => ({
  ...post,
  time: post.time || new Date().toLocaleString()
}));

// =========================
// TAMBAH POST
// =========================
function addPost() {

  let input = document.getElementById("postInput");
  let imageInput = document.getElementById("imageInput");

  let text = input.value.trim();
  let file = imageInput.files[0];

  if (text === "" && !file) {
    alert("Post tidak boleh kosong!");
    return;
  }

  let reader = new FileReader();

  reader.onload = function (e) {

    let newPost = {
      user: user.email,
      text: text,
      image: file ? e.target.result : null,
      likes: 0,
      comments: [],
      time: new Date().toLocaleString()
    };

    posts.unshift(newPost);

    localStorage.setItem("posts", JSON.stringify(posts));

    addNotification(`${user.email} membuat postingan baru`);

    renderPosts();
  };

  if (file) {
    reader.readAsDataURL(file);
  } else {
    reader.onload({
      target: { result: null }
    });
  }

  input.value = "";
  imageInput.value = "";
}

// =========================
// TAMBAH POST TERSTRUKTUR (ADMIN)
// =========================
function saveStructuredPost(htmlContent, file) {

  let reader = new FileReader();

  reader.onload = function (e) {

    let newPost = {
      user: user.email,
      text: htmlContent,
      image: file ? e.target.result : null,
      likes: 0,
      comments: [],
      time: new Date().toLocaleString()
    };

    posts.unshift(newPost);

    localStorage.setItem("posts", JSON.stringify(posts));

    addNotification(`${user.email} membuat dokumentasi baru`);

    renderPosts();
    
    alert("Dokumentasi berhasil diposting!");
    
    // Refresh halaman untuk reset form (opsional)
    location.reload();
  };

  if (file) {
    reader.readAsDataURL(file);
  } else {
    reader.onload({
      target: { result: null }
    });
  }
}

// =========================
// LIKE POST
// =========================
function likePost(index) {

  posts[index].likes++;

  localStorage.setItem("posts", JSON.stringify(posts));

  addNotification(`${user.email} menyukai postingan`);

  renderPosts();
}

// =========================
// KOMENTAR
// =========================
function toggleComment(index) {

  let box = document.getElementById(`comment-${index}`);

  box.style.display =
    (box.style.display === "none") ? "block" : "none";
}

function addComment(index) {

  let input = document.getElementById(`input-${index}`);
  let text = input.value.trim();

  if (text === "") return;

  posts[index].comments.push({
    user: user.email,
    text: text,
    time: new Date().toLocaleString()
  });

  localStorage.setItem("posts", JSON.stringify(posts));

  addNotification(`${user.email} berkomentar`);

  renderPosts();

  setTimeout(() => {
    document.getElementById(`comment-${index}`).style.display = "block";
  }, 100);
}

// =========================
// RENDER POST
// =========================
function renderPosts() {

  let postList = document.getElementById("postList");

  if (!postList) return;

  postList.innerHTML = "";

  posts.forEach((p, index) => {

    if (
      window.location.pathname.includes("profile.html") &&
      p.user !== user.email
    ) return;

    let post = document.createElement("div");
    post.className = "post";

    let commentsHTML = "";

    p.comments.forEach(c => {
      commentsHTML += `
        <div class="comment-item">

          <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:4px;
          ">

            <b>${c.user}</b>

            <small style="
              color:gray;
              font-size:11px;
            ">
              ${c.time || "Baru saja"}
            </small>

          </div>

          <p>${c.text}</p>

        </div>
      `;
    });

    post.innerHTML = `
    <div class="post-header">

      <b>${p.user}</b>

      <small style="display:block;color:gray;">
        ${p.time}
      </small>

    </div>

    <div class="post-text" style="margin: 10px 0;">${p.text}</div>

    ${p.image ? `<img src="${p.image}">` : ""}

    <div class="post-stats">
      <span>${p.likes} Like</span>
      <span>${p.comments.length} Komentar</span>
    </div>

    <div class="post-actions">

      <button onclick="likePost(${index})">
        ❤️ Suka
      </button>

      <button onclick="toggleComment(${index})">
        💬 Komentar
      </button>

    </div>

    <div class="comment-section"
        id="comment-${index}"
        style="display:none;">

      <div class="comment-list">
        ${commentsHTML}
      </div>

      <div class="comment-input">

        <input type="text"
              id="input-${index}"
              placeholder="Tulis komentar...">

        <button onclick="addComment(${index})">
          Kirim
        </button>

      </div>

    </div>
  `;

    postList.appendChild(post);
  });
}

// =========================
// NOTIFIKASI
// =========================
function addNotification(text) {

  let notif = {
    text: text,
    time: new Date().toLocaleString()
  };

  notifications.unshift(notif);

  localStorage.setItem("notifications", JSON.stringify(notifications));

  renderNotifications();
}

function renderNotifications() {

  let list = document.getElementById("notifList");

  if (!list) return;

  list.innerHTML = "";

  let latest = notifications[0];

  if (latest) {
    list.innerHTML = `
      <div class="notif-item">
        <p>${latest.text}</p>
        <small>${latest.time}</small>
      </div>
    `;
  }
}

function toggleAllNotif() {

  let box = document.getElementById("allNotif");

  if (!box) return;

  if (box.style.display === "block") {

    box.style.display = "none";
    return;
  }

  box.innerHTML = "";

  notifications.slice(0, 10).forEach(n => {

    box.innerHTML += `
      <div class="notif-item">

        <p>${n.text}</p>

        <small>${n.time}</small>

      </div>
    `;
  });

  box.style.display = "block";
}

// =========================
// CHAT
// =========================

let currentChatUser = "";

// BUKA CHAT
function openChat(friendName) {

  currentChatUser = friendName;

  document.getElementById("chatBox")
    .style.display = "block";

  document.getElementById("chatUsername")
    .innerText = friendName;

  renderChat();
}

// TUTUP CHAT
function closeChat() {

  document.getElementById("chatBox")
    .style.display = "none";
}

// AMBIL CHAT
function getChatKey() {
  return `chat_${user.email}_${currentChatUser}`;
}

// KIRIM PESAN
function sendMessage() {

  let textInput =
    document.getElementById("chatText");

  let text = textInput.value.trim();

  if (text === "") return;

  let chats =
    JSON.parse(localStorage.getItem(getChatKey()))
    || [];

  chats.push({
    sender: user.email,
    text: text,
    time: new Date().toLocaleString()
  });

  localStorage.setItem(
    getChatKey(),
    JSON.stringify(chats)
  );

  textInput.value = "";

  renderChat();
}

// RENDER CHAT
function renderChat() {

  let box =
    document.getElementById("chatMessages");

  if (!box) return;

  box.innerHTML = "";

  let chats =
    JSON.parse(localStorage.getItem(getChatKey()))
    || [];

  chats.forEach(chat => {

    let isMe = chat.sender === user.email;

    box.innerHTML += `

      <div class="message-wrapper
           ${isMe ? "my-message" : "friend-message"}">

        <div class="message">

          <b>${chat.sender}</b>

          <p>${chat.text}</p>

          <small>${chat.time}</small>

        </div>

      </div>

    `;
  });

  box.scrollTop = box.scrollHeight;
}
// =========================
// SAVE PROFILE
// =========================
function saveProfile() {

  let profileData = {
    name: document.getElementById("editName").value,
    job: document.getElementById("editJob").value,
    school: document.getElementById("editSchool").value,
    address: document.getElementById("editAddress").value,
    birth: document.getElementById("editBirth").value,
    gender: document.getElementById("editGender").value,
    division: document.getElementById("editDivisi").value
  };

  localStorage.setItem("profileData", JSON.stringify(profileData));

  alert("Profil berhasil disimpan!");
  window.location.href = "profile.html";
}

// =========================
// LOAD AWAL
// =========================
renderPosts();
renderNotifications();
renderGroups();