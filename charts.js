// $(document).ready(function(){

//     var options ={
//         series:[{
//             name: 'Revenue',
//             data:[101,64,78,79,42,109,100,230]
//         }],
//         chart:{
//             height:300,
//             type:'area',
//             toolbar:{
//                 show:false,
//             }
//         },
//         dataLabels: {
//             enabled:false
//         },
//         colors:['darkblue'],
//         stroke:{
//             curve:'smooth',
//         },
//         fill:{
//             type:'gradient',
//             gradient:{
//                 opacityFrom:0,
//                 opacityTo:0
//             }
//         },
//         tooltip:{
//             theme:'dark',
//         },
//         xaxis:{
//             categories:[
//                 "Jan",
//                 "Feb",
//                 "March",
//                 "April",
//                 "May",
//                 "June",
//                 "July",
//                 "Aug",
//                 "Sep",
//                 "Oct",
//                 "Nov",
//                 "Dec"

//             ],
//             labels:{
//                 style:{
//                     colors:'black'
//                 }
//             },
//         },
//         yaxis:{
//             labels:{
//                 style:{
//                     colors:'black'
//                 }
//             }
//         },
//         legend:{
//             labels:{
//                 colors:'white'
//             },
//         },
//     };
//     var chart = new ApexCharts(document.querySelector("#chLine"),options);
//     chart.render();
// })