export default {
  items: [
    {
      name: 'Inicio',
      url: '/dashboard',
      icon: 'icon-speedometer',
      badge: {
        /*variant: 'info',
        text: 'NEW',*/
      },
    },
    {
      title: true,
      name: 'Administración',
      wrapper: {            // optional wrapper object
        element: '',        // required valid HTML5 element tag
        attributes: {}        // optional valid JS object with JS API naming ex: { className: "my-class", style: { fontFamily: "Verdana" }, id: "my-id"}
      },
      class: ''             // optional class names space delimited list for title item ex: "text-center"
    },
    /*{
      name: 'Colors',
      url: '/theme/colors',
      icon: 'icon-drop',
    },*/
    {
      name: 'Registrar Instrumental',
      url: '/configuracion/instrumental',
      icon: 'icon-pencil',
    },
    {
      title: true,
      name: 'Administración',
      wrapper: {
        element: '',
        attributes: {},
      },
    },
    {
      name: 'Productos',
      url: '/configuracion/productos',
      icon: 'icon-pencil',
    },
    /*{
      name: 'Pages',
      url: '/pages',
      icon: 'icon-star',
      children: [
        {
          name: 'Login',
          url: '/login',
          icon: 'icon-star',
        },
        {
          name: 'Register',
          url: '/register',
          icon: 'icon-star',
        },
        {
          name: 'Error 404',
          url: '/404',
          icon: 'icon-star',
        },
        {
          name: 'Error 500',
          url: '/500',
          icon: 'icon-star',
        },
      ],
    }*/
  ],
};
