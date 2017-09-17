$(function() {

    Morris.Area({
        element: 'morris-area-chart',
        data: [{
            period: '2010 Q1',
            mcoat: 2666,
            dagupan: null,

        }, {
            period: '2010 Q2',
            mcoat: 2778,
            dagupan: 2294,

        }, {
            period: '2010 Q3',
            mcoat: 4912,
            dagupan: 1969,

        }, {
            period: '2010 Q4',
            mcoat: 3767,
            dagupan: 3597,

        }, {
            period: '2011 Q1',
            mcoat: 6810,
            dagupan: 1914,

        }, {
            period: '2011 Q2',
            mcoat: 5670,
            dagupan: 4293,

        }, {
            period: '2011 Q3',
            mcoat: 4820,
            dagupan: 3795,

        }, {
            period: '2011 Q4',
            mcoat: 15073,
            dagupan: 5967,

        }, {
            period: '2012 Q1',
            mcoat: 10687,
            dagupan: 4460,

        }, {
            period: '2012 Q2',
            mcoat: 8432,
            dagupan: 5713,

        }],
        xkey: 'period',
        ykeys: ['mcoat', 'dagupan'],
        labels: ['mcoat', 'dagupan'],
        pointSize: 2,
        hideHover: 'auto',
        resize: true
    });

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Download Sales",
            value: 12
        }, {
            label: "In-Store Sales",
            value: 30
        }, {
            label: "Mail-Order Sales",
            value: 20
        }],
        resize: true
    });



});