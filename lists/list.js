class ListTable {
    static instance = null;

    constructor() {
        this.table = document.getElementsByTagName("tbody")[0];
        this.selectedRowIndex = undefined;
    }

    static getInstance() {
        if(ListTable.instance == null) {
            ListTable.instance = new ListTable();
        }
        return ListTable.instance;
    }

    setRowIndex(index) {
        this.selectedRowIndex = index;
    }

}

var NUM_ROWS = 3;
var names = ["Maxi", "Pijaca", "4audio"];
var img_srcs = ["imgs/shopping-list.png", "imgs/shopping-list.png", "imgs/shopping-list.png"];

function onLoad() {
    var table = ListTable.getInstance();

    for (let i = 0; i < NUM_ROWS; i++) {
        row = table.table.insertRow(table.table.length); // create empty <tr> element at last position
        cellImg = row.insertCell(0);
        cellName = row.insertCell(1);
        cellActions = row.insertCell(2);
        cellImg.innerHTML = "<img src=" + img_srcs[i] + " style='border-radius: 50%;' class='avatar img-circle'>";
        cellName.innerHTML = names[i]; // GOBELJA PAGE
        cellActions.innerHTML = "<div class='btn-group btn-group' role='group'>" +
            "<a href='./singleList1.html' class='btn btn-outline-info' role='button' aria-pressed='true'>Info</a>" +
            "<a href='#' class='btn btn-outline-success' role='button' aria-pressed='true'>Create Link</a>" +
            "<a href='./editList1.html' class='btn btn-outline-primary' role='button' aria-pressed='true'>Edit</a>" +
            "<a href='#' class='btn btn-outline-danger' onclick='setRowIndex(this)' role='button' aria-pressed='true' data-toggle='modal' data-target='#exampleModalCenter'>Mark done</a>" +
         "</div>";
    }
}

function deleteList() {
    table = ListTable.getInstance();
    table.table.deleteRow(table.selectedRowIndex);
}