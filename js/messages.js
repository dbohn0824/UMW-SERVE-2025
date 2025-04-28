function sendDelete(id) {
    sendAJAXRequest('deleteNotification.php?id=' + id, {}, deleteCallback);
}

function deleteCallback() {
    let response = JSON.parse(this.responseText);
    if (response.result) {
        // Remove the row from the table without refreshing the page
        $('tr[data-message-id="' + this.responseText + '"]').remove();
    } else {
        alert('Failed to delete the notification.');
    }
}

function sendAJAXRequest(url, requestData, onSuccess, onFailure) {
    var request = new XMLHttpRequest();
    request.open("POST", url, true);
    request.setRequestHeader("Content-Type", "application/json");
    request.onload = onSuccess;
    request.onerror = onFailure;
    request.send(JSON.stringify(requestData));
    return false;
}

$(function() {
    $('.delete-button').click(function(e) {
        e.preventDefault();

        let id = $(this).data('message-id');
        sendDelete(id); 
    });

    $('tr.message').on('click', function(e) {
        // Only proceed if the clicked cell is NOT the first cell (checkbox column)
        const clickedCell = $(e.target).closest('td');
        const cellIndex = clickedCell.index();

        // Don't navigate if clicked inside the checkbox column (index 0)
        if (cellIndex === 0 || $(e.target).is('input[type="checkbox"]')) {
            return;
        }

        const id = $(this).data('message-id');
        if (id) {
            window.location = 'viewNotification.php?id=' + id;
        }
    });
});

function toggleSelectAll(source) {
    const checkboxes = document.querySelectorAll('input[name="selected_messages[]"]');
    checkboxes.forEach(cb => cb.checked = source.checked);
}

let confirmFunction = null;
function setConfirmFunction(fn) {
    confirmFunction = fn;
}
function handleFormSubmit() {
    if (confirmFunction) {
        return confirmFunction();
    }
    return true; // default allow
}
function confirmDelete() {
    return confirm("Are you sure you want to delete these messages?");
}
function confirmUnread() {
    return confirm("Are you sure you want to mark these messages as unread?");
}
function confirmRead() {
    return confirm("Are you sure you want to mark these messages as read?");
}
