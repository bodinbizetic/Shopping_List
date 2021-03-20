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

var NUM_ROWS = 4;
var names = ["Sanja Markovic (You)","Vesna Markovic", "Goran Markovic", "Luka Markovic"];
var per = [true, false, false, false];

function onLoad() {
    var table = Table.getInstance();
    
    for (let i = 0; i < NUM_ROWS; i++) {
        row = table.table.insertRow(table.table.length); // create empty <tr> element at last position
        cellName = row.insertCell(0);
        cellPermission = row.insertCell(1);
        cellActions = row.insertCell(2);
        cellName.innerHTML = names[i];

        radio = document.createElement("input");
        radio.setAttribute("type", "radio");
        radio.checked = per[i];
        cellPermission.appendChild(radio);
        radio.checked = per[i];

        cellActions.innerHTML = "<div class='btn-group btn-group' role='group'>" +                      
            "<a href='#' class='btn btn-outline-danger' onclick='setRowIndex(this)' role='button' aria-pressed='true' data-toggle='modal' data-target='#exampleModalCenter'>Remove</a>" +
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