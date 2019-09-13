$(document).ready(function(){
        var calendar = $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'month,agendaWeek,agendaDay'
            },
            defaultView: 'month',
            editable: true,
            selectable: true,
            allDaySlot: false,




            eventClick:  function(event, jsEvent, view) {
                endtime = $.fullCalendar.moment(event.end).format('h:mm');
                starttime = $.fullCalendar.moment(event.start).format('dddd, MMMM Do YYYY, h:mm');
                var mywhen = starttime + ' - ' + endtime;
                $('#modalNbrCoupon').html(event.nbrCoupon);
                $('#modalWhen').text(mywhen);
                $('#eventID').val(event.id);
                $('#calendarModal').modal();
            },

            //header and other values
            select: function(start, end, jsEvent) {
                start = moment(start);
                end = moment(end);
                $('#BonPlanbundle_event_startdate_date').val(start.format('YYYY-MM-DD'));
                $('#BonPlanbundle_event_startdate_time').val(start.format('HH:mm'));
                $('#BonPlanbundle_event_enddate_date').val(end.format('YYYY-MM-DD'));
                $('#BonPlanbundle_event_enddate_time').val(end.format('HH:mm'));
                $('#createEventModal').modal('toggle');
           },
           eventDrop: function(event, delta){
               var data = new FormData();
               console.log(event);
               data.append('BonPlanbundle_event[startdate][date]',event.start.format('YYYY-MM-DD'));
               data.append('BonPlanbundle_event[startdate][time]',event.start.format('HH:mm'));
               data.append('BonPlanbundle_event[enddate][date]',event.start.format('YYYY-MM-DD'));
               data.append('BonPlanbundle_event[enddate][time]',event.start.format('HH:mm'));
               //alert(data);
               $.ajax({
                   url:  event_update_path.replace(/id/,event.id),
                   data: data,
                   processData: false,
                   contentType: false,
                   type: "POST",
                   success: function(json) {
                       //alert(json);
                   }
               });
           },
           eventResize: function(event) {
               var data = new FormData();

               data.append('BonPlanbundle_event[startdate][date]',event.start.format('YYYY-MM-DD'));
               data.append('BonPlanbundle_event[startdate][time]',event.start.format('HH:mm'));
               data.append('BonPlanbundle_event[enddate][date]',event.end.format('YYYY-MM-DD'));
               data.append('BonPlanbundle_event[enddate][time]',event.end.format('HH:mm'));



               $.ajax({
                   url:  event_update_path.replace(/id/,event.id),
                   data: data,
                   processData: false,
                   contentType: false,
                   type: "POST",
                   success: function(json) {
                       alert(json);
                   }
               });
           }
        });

       $('#submitButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doSubmit();
       });

       $('#deleteButton').on('click', function(e){
           // We don't want this to act as a link so cancel the link action
           e.preventDefault();
           doDelete();
       });

       function doDelete(){
           $("#calendarModal").modal('hide');

           var eventID = $('#eventID').val();
        var url = event_delete_path.replace(/id/,eventID);
           console.log(url);
           $.ajax({
               url: event_delete_path.replace(/id/,eventID),
               type: "POST",
               success: function(json) {
                   location.reload();
               }
           });
       }
       function doSubmit(){
           $("#createEventModal").modal('hide');




          var form = $('form[name="BonPlanbundle_event"]');
           var data = new FormData(form[0]);
           $('#BonPlanbundle_event_nbCoupon').val("");



           $.ajax({
               url: window.event_submit_path,
               data: data,
               processData: false,
               contentType: false,
               type: "POST",
               success: function(json) {
                   $("#calendar").fullCalendar('renderEvent',
                   {
                       id: e.id,
                       title: e.nbrCoupon,
                       start: e.startdate.date,
                       end: e.enddate.date,
                   },
                   true);
               }
           });

       }
    });