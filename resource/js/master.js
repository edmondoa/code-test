
$( document ).ready(function() {
  
    getList();
  
    $("body").delegate(".btn-add-task",'click',function(event){
      event.preventDefault();
      data = {'taskName':$("[name=name]").val(),'priority':$("[name=priority]").val(),'taskDescription':$("[name=description]").val(),'action':'addTask' };
      postRequest(data);
      clearForm();
      $('#exampleModal').modal('hide')
    })

    $("table").delegate(".btn-complete",'click',function(event){
      event.preventDefault();
      data = {'id':$(this).data('id'),'action':'markComplete' };
      postRequest(data);
    });

    $("table").delegate(".btn-view",'click',function(event){
      event.preventDefault();
      data = {'id':$(this).data('id'),'action':'view' };
      getView(data);
    });

    $("table").delegate(".btn-delete",'click',function(event){
      event.preventDefault();
      data = {'id':$(this).data('id'),'action':'delete' };
      var ans = confirm("Are yo sure you want to delete this ?");
      if(ans)
        postRequest(data);
    })

    $("body").delegate(".btn-update-task",'click',function(event){
      event.preventDefault();
      data = {'taskName':$("#update-name").val(),'priority':$("#update-priority").val(),'taskDescription':$("#update-description").val(),'id':$("#id").val(),'action':'updateTask' };
      postRequest(data);
      $('#viewModal').modal('hide')
    })

    $("body").delegate('#sort-by','change',function(){
      getList();
    })

    $("body").delegate('#show-by','change',function(){
      getList();
    })
    
});

var getList = function(){

  data = {'action':'displayList','sortBy':$("#sort-by").val(),'showBy':$("#show-by").val()};
  $.ajax({
      url: "controller/proccesor.php",
      type: "POST",
      data: data,
      dataType: 'json',
      context: document.body
    }).done(function(result) {
      $( "#list-table" ).html( result.tasks );
      $("#total-completed").html( result.completed);
      $("#total").html( result.total);
    });

}

var postRequest = function(data){
  $.ajax({
    url: "controller/proccesor.php",
    type: "POST",
    data: data,
    context: document.body
  }).done(function() {
      getList();
  });
}

var getView = function(){
  $.ajax({
    url: "controller/proccesor.php",
    type: "POST",
    data: data,
    dataType: 'json',
    context: document.body
  }).done(function(result) {
      $("#id").val(result[0].id);
      $("#update-name").val(result[0].task_name);
      $("#update-priority").val(result[0].priority);
      $("#update-description").val(result[0].description);
    });
}


// clear form values
var clearForm = function(){
  $("[name=name]").val('');
  $("[name=priority]").val('');
  $("[name=description]").val('');
}

