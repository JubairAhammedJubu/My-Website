<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard (CSS-Only - Radio Buttons)</title>
<link rel="stylesheet" href="https://unpkg.com/ionicons@5.5.2/dist/css/ionicons.min.css">


<style>
/* === Base Styles === */
body {
  font-family: 'Poppins', sans-serif;
  background: linear-gradient(135deg, #e0f7ff, #f0faff);
  overflow-x: hidden;
  transition: background 2s ease;
}

/* === Header (Animated Gradient) === */
.top-bar {
  position: fixed;
  top: 0;
  left: 0;
  width: 96%;
  height: 70px;
  background: linear-gradient(90deg, #007CF0, #00DFD8, #007CF0);
  background-size: 300% 300%;
  animation: gradientFlow 6s ease infinite;
  color: white;
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0 30px;
  z-index: 1000;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
  border-bottom: 2px solid rgba(255, 255, 255, 0.2);
}

/* === Sidebar (Vertical Animated Gradient) === */
nav {
  position: fixed;
  top: 90px;
  bottom: 70px;
  left: 0;
  width: 250px;
  background: linear-gradient(180deg, #5D0EFF, #00E0FF, #5D0EFF);
  background-size: 200% 200%;
  animation: gradientFlow 8s ease infinite;
  color: white;
  padding: 10px;
  border-radius: 0 15px 15px 0;
  overflow-y: auto;
  box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
}

/* === Footer (Soft Glow) === */
footer {
  position: fixed;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 50px;
  background: linear-gradient(90deg, #00DFD8, #5D0EFF);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  box-shadow: 0 -2px 6px rgba(0, 0, 0, 0.3);
}

/* === Sidebar Items === */
nav label {
  display: flex;
  align-items: center;
  height: 50px;
  padding-left: 10px;
  font-size: 18px;
  cursor: pointer;
  transition: all 0.3s;
  border-radius: 25px;
}

nav label:hover {
  background: rgba(255, 255, 255, 0.15);
  box-shadow: inset 0 0 10px rgba(255, 255, 255, 0.2);
}

/* === Active Tab === */
input[type="radio"] {
  display: none;
}

#dashboard:checked ~ nav label[for="dashboard"],
#content:checked ~ nav label[for="content"],
#analytics:checked ~ nav label[for="analytics"],
#likes:checked ~ nav label[for="likes"],
#comments:checked ~ nav label[for="comments"] {
  background: rgba(255, 255, 255, 0.3);
  color: #fff;
  font-weight: bold;
}

/* === Main === */
main {
  margin-left: 250px;
  padding: 100px 30px 80px 30px;
  max-width: calc(100% - 250px);
  min-height: 100vh;
}

/* === Dynamic Welcome Section === */
.welcome-section {
  background: linear-gradient(135deg, #6EE7B7, #3B82F6, #9333EA);
  background-size: 200% 200%;
  animation: gradientFlow 10s ease infinite;
  color: white;
  padding: 30px;
  border-radius: 12px;
  margin-bottom: 25px;
  box-shadow: 0 3px 10px rgba(0, 0, 0, 0.3);
}

/* === Data Boxes === */
.boxes {
  display: flex;
  gap: 15px;
  flex-wrap: wrap;
}

.box {
  flex: 1;
  min-width: 160px;
  text-align: center;
  padding: 20px;
  border-radius: 12px;
  color: #fff;
  font-weight: 500;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
  background: linear-gradient(135deg, var(--box-start), var(--box-end));
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.box:hover {
  transform: translateY(-5px);
  box-shadow: 0 6px 15px rgba(0, 0, 0, 0.3);
}

/* === Individual Box Colors === */
.box1 { --box-start: #F472B6; --box-end: #EC4899; }
.box2 { --box-start: #34D399; --box-end: #059669; }
.box3 { --box-start: #60A5FA; --box-end: #2563EB; }
.box4 { --box-start: #FBBF24; --box-end: #F59E0B; }

.box .number {
  font-size: 36px;
  font-weight: 700;
}

/* === Buttons === */
button {
  background: linear-gradient(135deg, #2563EB, #3B82F6);
  color: white;
  border: none;
  padding: 10px 18px;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
}

button:hover {
  background: linear-gradient(135deg, #3B82F6, #9333EA);
  transform: scale(1.05);
}

/* === Keyframes for Animated Gradient === */
@keyframes gradientFlow {
  0% { background-position: 0% 50%; }
  50% { background-position: 100% 50%; }
  100% { background-position: 0% 50%; }
}
</style>

</head>
<body>

<!-- Radio inputs to control section display -->
<input type="radio" name="menu" id="dashboard" checked>
<input type="radio" name="menu" id="content">
<input type="radio" name="menu" id="analytics">
<input type="radio" name="menu" id="likes">
<input type="radio" name="menu" id="comments">

<!-- Sidebar -->
<nav>
  <div class="menu-items">
    <label for="dashboard"><ion-icon name="home-outline"></ion-icon><span>Dashboard</span></label>
    <label for="content"><ion-icon name="folder-outline"></ion-icon><span>Content</span></label>
    <label for="analytics"><ion-icon name="analytics-outline"></ion-icon><span>Analytics</span></label>
    <label for="likes"><ion-icon name="heart-outline"></ion-icon><span>Likes</span></label>
    <label for="comments"><ion-icon name="chatbubbles-outline"></ion-icon><span>Comments</span></label>
  </div>
</nav>

<!-- Dashboard Content -->
<section class="dashboard">
  <!-- Dashboard Section -->
  <div class="data-table dashboard-section">
    <div class="title"><ion-icon name="speedometer"></ion-icon><span class="text">Dashboard</span></div>
    <div class="boxes">
      <div class="box box1"><ion-icon name="eye-outline"></ion-icon><div>Total Views</div><div class="number">18345</div></div>
      <div class="box box2"><ion-icon name="people-outline"></ion-icon><div>Active Users</div><div class="number">2745</div></div>
      <div class="box box3"><ion-icon name="chatbubbles-outline"></ion-icon><div>Activities</div><div class="number">1209</div></div>
      <div class="box box4"><ion-icon name="car-sport-outline"></ion-icon><div>Insured Vehicles</div><div class="number">123</div></div>
    </div>
  </div>

  <!-- Content Section -->
  <div class="data-table content-section">
    <div class="title"><ion-icon name="folder-outline"></ion-icon><span class="text">Content</span></div>
    <p>Manage and review uploaded content here.</p>
  </div>

  <!-- Analytics Section -->
  <div class="data-table analytics-section">
    <div class="title"><ion-icon name="analytics-outline"></ion-icon><span class="text">Analytics</span></div>
    <p>View analytics charts and performance metrics.</p>
  </div>

  <!-- Likes Section -->
  <div class="data-table likes-section">
    <div class="title"><ion-icon name="heart-outline"></ion-icon><span class="text">Likes</span></div>
    <p>View and manage likes data here.</p>
  </div>

  <!-- Comments Section -->
  <div class="data-table comments-section">
    <div class="title"><ion-icon name="chatbubbles-outline"></ion-icon><span class="text">Comments</span></div>
    <p>Monitor recent comments from users.</p>
  </div>
</section>

</body>
</html>




