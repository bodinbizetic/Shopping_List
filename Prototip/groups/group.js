class Table {
    static instance = null;

    constructor() {
        this.table = document.getElementsByTagName("tbody")[0];
        this.selectedRowIndex = undefined;
    }

    static getInstance() {
        if(Table.instance == null) {
            Table.instance = new Table();
        }
        return Table.instance;
    }

    setRowIndex(index) {
        this.selectedRowIndex = index;
    }

}

var NUM_ROWS = 5;
var names = ["Elektrijada", "Porodica", "Zurka", "Nova godina", "More", "Zimovanje", "Drustvo", "Posao", "Piknik"];
var img_srcs = ["./imgs/friends.jpg", "./imgs/friends.jpg", "./imgs/friends.jpg", "./imgs/friends.jpg", "./imgs/friends.jpg", "./imgs/friends.jpg", "./imgs/friends.jpg", "./imgs/friends.jpg", "./imgs/friends.jpg"]; 

function onLoad() {
    var table = Table.getInstance();
    
    for (let i = 0; i < NUM_ROWS; i++) {
        row = table.table.insertRow(table.table.length); // create empty <tr> element at last position
        cellImg = row.insertCell(0);
        cellName = row.insertCell(1);
        cellActions = row.insertCell(2);
        cellImg.innerHTML = "<img src=" + img_srcs[i] + " style='border-radius: 50%;' class='avatar img-circle'>";
        cellName.innerHTML = names[i];
        cellActions.innerHTML = "<div class='btn-group btn-group' role='group'>" + 
            "<a href='singleGroup1.html' class='btn btn-outline-info' role='button' aria-pressed='true'>Info</a>" +                     
            "<a href='../lists/list.html' class='btn btn-outline-success' role='button' aria-pressed='true'>Lists</a>" +
            "<a href='editGroup1.html' class='btn btn-outline-primary' role='button' aria-pressed='true'>Edit</a>" +
            "<a href='#' class='btn btn-outline-danger' onclick='setRowIndex(this)' role='button' aria-pressed='true' data-toggle='modal' data-target='#exampleModalCenter'>Leave</a>" +
         "</div>";
    }
}

function setRowIndex(a_href) {
    table = Table.getInstance();
    while(a_href.nodeName.toLowerCase() != 'tr')
        a_href = a_href.parentNode;
    table.selectedRowIndex = a_href.rowIndex - 1;
}


function leaveGroup() {
    table = Table.getInstance();
    table.table.deleteRow(table.selectedRowIndex);
}