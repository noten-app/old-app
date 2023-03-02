// Load calendars

grid_calendar = undefined;
list_calendar = undefined;

document.addEventListener('DOMContentLoaded', function() {
    list_calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        headerToolbar: {
            left: 'prev,next',
            right: 'title'
        },
        navLinks: false,
        editable: true,
        dayMaxEvents: true,
        locale: "en",
        events: cal_events,
        nowIndicator: true,
        selectable: true,
        selectMirror: true,
        initialView: 'listMonth',
        eventClick: function(info) {
            calClick(list_calendar, info.event);
        },
        dateClick: function(info) {
            dateClick(list_calendar, info.dateStr);
        },
        select: function(info) {
            dateRange(list_calendar, info);
        }
    });
    list_calendar.render();
});

// Functions
function calClick(calendar, event) {
    alert('Event: ' + event.id);
    alert('Cal: ' + calendar);
}

function dateClick(calendar, date) {
    alert('Date: ' + date);
    alert('Cal: ' + calendar);
}

function dateRange(calendar, event) {
    alert('Date: ' + event);
    alert('Cal: ' + calendar);
}