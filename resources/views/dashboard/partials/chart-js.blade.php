<script>
document.addEventListener('DOMContentLoaded', function(){
  // Messages Over Time
  const m = document.getElementById('messagesChart')?.getContext('2d');
  if (m) new Chart(m, {
    type: 'line',
    data: {
      labels: ['Aug 10','Aug 11','Aug 12','Aug 13','Aug 14','Aug 15','Aug 16'],
      datasets: [
        { label:'Sent', data:[6500,7200,8100,7800,8500,8900,8240], borderColor:'#25D366', backgroundColor:'rgba(37,211,102,0.1)', tension:0.4 },
        { label:'Delivered', data:[6200,6900,7800,7500,8200,8600,7950], borderColor:'#3B82F6', backgroundColor:'rgba(59,130,246,0.1)', tension:0.4 },
        { label:'Read', data:[4800,5400,6200,5900,6500,6800,6300], borderColor:'#10B981', backgroundColor:'rgba(16,185,129,0.1)', tension:0.4 },
      ]
    },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false }}, scales:{ y:{ beginAtZero:true, grid:{ color:'rgba(0,0,0,0.05)'}}, x:{ grid:{ display:false }}}}
  });

  // Template Usage
  const t = document.getElementById('templateChart')?.getContext('2d');
  if (t) new Chart(t, {
    type: 'doughnut',
    data: { labels:['Approved','Drafts','Rejected'], datasets:[{ data:[70,20,10], backgroundColor:['#10B981','#F59E0B','#EF4444'], borderWidth:0 }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false }}, cutout:'60%' }
  });

  // Campaign Performance
  const c = document.getElementById('campaignChart')?.getContext('2d');
  if (c) new Chart(c, {
    type: 'bar',
    data: { labels:['Raksha Bandhan','Flash Sale','Product Launch'], datasets:[{ label:'Messages Sent', data:[12500,4230,0], backgroundColor:['#10B981','#3B82F6','#F59E0B'], borderRadius:4 }] },
    options:{ responsive:true, maintainAspectRatio:false, plugins:{ legend:{ display:false }}, scales:{ y:{ beginAtZero:true, grid:{ color:'rgba(0,0,0,0.05)'}}, x:{ grid:{ display:false }}}}
  });
});
</script>
