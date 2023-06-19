function userTypeCheck() 
{   
   if(document.getElementById('dot-2').checked) 
   {
      document.getElementById('ifLensman').style.display = 'block';
      document.getElementById('ifLensman1').style.display = 'block';
      document.getElementById('ifLensman2').style.display = 'block';
      document.getElementById('ifLensman3').style.display = 'block';
      document.getElementById('lensmanMap').style.display = 'block';
      document.getElementById('id_upload').disabled = false;
      document.getElementById('permit_upload').disabled = false;
      document.getElementById('studio_name').disabled = false;
      document.getElementById('tin').disabled = false;
      document.getElementById('lat').disabled = false;
      document.getElementById('lng').disabled = false;
   }
   else 
   {
      document.getElementById('ifLensman').style.display = 'none';
      document.getElementById('ifLensman1').style.display = 'none';
      document.getElementById('ifLensman2').style.display = 'none';
      document.getElementById('ifLensman3').style.display = 'none';
      document.getElementById('lensmanMap').style.display = 'none';
      document.getElementById('id_upload').disabled = true;
      document.getElementById('permit_upload').disabled = true;
      document.getElementById('studio_name').disabled = true;
      document.getElementById('tin').disabled = true;
      document.getElementById('lat').disabled = true;
      document.getElementById('lng').disabled = true;
   }
}
