class ListTable {
    static instance = {};
    static lastTable = null;
    static lastIndex = -1;

    constructor(name) {
        this.table = document.getElementById(name);
        this.selectedRowIndex = undefined;
        this.shareLink = undefined;
    }

    static getInstance(name) {
        if(!(name in ListTable.instance)) {
            ListTable.instance[name] = new ListTable(name);
        }
        return ListTable.instance[name];
    }

    static setRowIndex(name, index) {
        ListTable.lastTable = name
        ListTable.lastIndex = index
    }

}

var NUM_TABLES = 2
var NAMES_TABLES = ["tbody1", "tbody2"]
var NUM_ROWS = 3;
var names = ["Maxi", "Pijaca", "4audio"];
var img_srcs = ["imgs/shopping-list.png", "imgs/shopping-list.png", "imgs/shopping-list.png"];

function onLoad() {
    for (let j=0; j<NUM_TABLES; j++) {
        var table = ListTable.getInstance(NAMES_TABLES[j]);

        for (let i = 0; i < NUM_ROWS; i++) {
            row = table.table.insertRow(table.table.length); // create empty <tr> element at last position
            cellImg = row.insertCell(0);
            cellName = row.insertCell(1);
            cellActions = row.insertCell(2);
            cellImg.innerHTML = "<img src=" + img_srcs[i] + " style='border-radius: 50%;' class='avatar img-circle'>";
            cellName.innerHTML = names[i];
            cellActions.innerHTML = "<div class='btn-group btn-group' role='group'>" +
            "<a href='./editList1.html' class='btn btn-outline-primary' role='button' aria-pressed='true'>Edit</a>" +
            "<a href='#' class='btn btn-outline-success' role='button' aria-pressed='true' data-toggle='modal' data-target='#createLinkModal' onclick='setShareLink(this)'>Create Link</a>" +
            "<a href='#' class='btn btn-outline-danger' onclick='ListTable.setRowIndex(\"" + NAMES_TABLES[j] + "\", this)' role='button' aria-pressed='true' data-toggle='modal' data-target='#deleteLinkModal'>Delete</a>" +
            "</div>";
        }
    }
}

function deleteList() {
    if (ListTable.lastTable == null)
        return;

    table = ListTable.getInstance(ListTable.lastTable);
    table.table.deleteRow(ListTable.lastIndex.parentNode.parentNode.parentNode.rowIndex)
}

function setShareLink(a_href) {
    table = Table.getInstance();
    while(a_href.nodeName.toLowerCase() != 'tr')
        a_href = a_href.parentNode;
    selectedRowIndex = a_href.rowIndex - 1;
    shareLink = "listLink"
}