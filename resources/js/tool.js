const routes = [{
    path: '/help/home',
    redirect: '/help'
}];
let sidebar = [];

Nova.config.pages.map((page) => {
    let route = {
        name: `help/${page.pageRoute}`,
        path: `/help/${page.pageRoute}`,
        component: require('./components/Page'),
        props: {
            file: page.file,
            title: page.title,
            content: page.content,
            pageTitle: page.pageTitle,
            pageRoute: page.pageRoute,
            sidebar: []
        }
    };

    if (page.home) {
        route.name = 'help';
        route.path = '/help';

        routes.push(route);
    } else {
        routes.push(route);
    }

    routes.forEach(route => {
        if (route.props) {
            sidebar.push({
                name: route.name,
                title: route.props.pageTitle
            })
        }
    });

    sidebar = _.uniqBy(sidebar, function (e) {
        return e.name;
    });

    routes.forEach(route => {
        if (route.props) {
            route.props.sidebar = sidebar
        }
    })
})

Nova.booting((Vue, router, store) => {
    router.addRoutes(routes)
})
