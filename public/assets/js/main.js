const select = document.getElementById('selectCity');

select.addEventListener('change', function(){
  window.location.href = select.value
})
