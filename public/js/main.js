
const tableBody = document.querySelector(".tbl-body");
// const loader = document.getElementById("loader");

var auto_refresh = setInterval(
  function ()
  {
    addContent();
  }, 10000); 



let url = "http://10.91.100.145:92/api/ssd/network_monitoring/connections";
let page = 1;
const fetchData = async () => {
  let result = await fetch(url, {
    method: "GET",
  });

  let data = await result.json();
  return data;
};

const addContent = async () => {
  tableBody.innerHTML = '';
  // loader.classList.add("show");
  let data = await fetchData();
 
  data.forEach((post) => {
   
    let prev_timestamp = post.previous_timestamp;
    // Create a new JavaScript Date object based on the timestamp
    // multiplied by 1000 so that the argument is in milliseconds, not seconds.
    var date = new Date(prev_timestamp  * 1000);
    // Hours part from the timestamp
    var hours = date.getHours();
    // Minutes part from the timestamp
    var minutes = "0" + date.getMinutes();
    // Seconds part from the timestamp
    var seconds = "0" + date.getSeconds();

    // Will display time in 10:30:23 format
    var prev_formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

    
    let curr_timestamp = post.current_timestamp;
    // Create a new JavaScript Date object based on the timestamp
    // multiplied by 1000 so that the argument is in milliseconds, not seconds.
    var date = new Date(curr_timestamp  * 1000);
    // Hours part from the timestamp
    var hours = date.getHours();
    // Minutes part from the timestamp
    var minutes = "0" + date.getMinutes();
    // Seconds part from the timestamp
    var seconds = "0" + date.getSeconds();

    // Will display time in 10:30:23 format
    var curr_formattedTime = hours + ':' + minutes.substr(-2) + ':' + seconds.substr(-2);

  
    const tblRow = document.createElement("tr");
    tblRow.className = "table-row";
    tblRow.innerHTML = `
    <td class="store-code" data-label="Store Code">
    ${post.store_code}
    </td>
    <td data-label="IP">
    ${post.previous_ip}
    </td>
    <td data-label="Current IP">
    ${post.current_ip}
    </td>
    <td data-label="Previous timestamp">
    ${prev_formattedTime}
    </td>
    <td data-label="Current timestamp">
    ${curr_formattedTime}
    </td>
    <td class="connection" data-label="Connection">
    ${post.status}
    </td>
    `;

    tableBody.appendChild(tblRow);
    tbOddrows();
    // loader.classList.remove("show");
  });

  colorConnection()
};
addContent();

async function colorConnection() {
  // get a reference to the table
  const table = tableBody;

  // get all the rows of the table
  const rows = table.getElementsByTagName("tr");

  // iterate over the rows and read the inner text of the desired column
  for (let i = 0; i < rows.length; i++) {

    cell3 = rows[i].cells[5];
    if (cell3.innerText === "Disconnected") {
      cell3.classList.add("red");
      cell3.classList.remove("green");
    }else {
      cell3.classList.remove("red");
      cell3.classList.add("green");
    }
  }
}

async function tbOddrows() {
  let rows = tableBody.getElementsByTagName("tr");

  // Loop through each row
  for (var i = 0; i < rows.length; i++) {
    // If the row number is odd, set the background color to gray
    if (i % 2 !== 0) {
      rows[i].style.backgroundColor = "#f5f5f5";
    }
  }
}


