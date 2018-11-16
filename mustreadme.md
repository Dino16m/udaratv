readme
Anyone using this app or contributing in any way to its development is required to read this

Before this app is run on any server the following must be done,
1. An init script must be run which will create the requisite directories on the server
2. Database migrations must be run
3. I have very little idea of howw paginationa ctually works and I need to test it. Ii is sprinkled all over thr categoryController
 	the paginate view should implement a the paginator view for that particular thing e.g seasons paginator will be like seasons->links('seasons_index')
