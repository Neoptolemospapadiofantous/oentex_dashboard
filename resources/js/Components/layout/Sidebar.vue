<template>
    <div :class="{ 'dark text-white-dark': store.semidark }">
      <!-- Sidebar with dynamic width based on collapse state -->
      <nav
        :class="[
          'sidebar fixed min-h-screen h-full top-0 bottom-0 shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300',
          store.sidebar ? 'w-[60px]' : 'w-[260px]',
        ]"
      >
        <div class="bg-white dark:bg-[#0e1726] h-full">
          <div class="flex justify-between items-center px-4 py-3">
            <!-- Hide the logo when sidebar is collapsed -->
            <router-link
              v-if="!store.sidebar"
              to="/"
              class="main-logo flex items-center shrink-0"
            >
              <img
                class="w-8 ml-[5px] flex-none"
                src="/assets/images/logo.svg"
                alt=""
              />
              <span
                class="text-2xl ltr:ml-1.5 rtl:mr-1.5 font-semibold align-middle lg:inline dark:text-white-light"
              >
                VRISTO
              </span>
            </router-link>
           <!-- Collapse/Expand icon -->
           <a
            href="javascript:;"
            class="collapse-icon w-8 h-8 rounded-full flex items-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180 hover:text-primary"
            @click="toggleSidebar"
          >
          <IconCaretsDown :rotate="store.sidebar ? 90 : 270" />



          </a>
        </div>
        <!-- Hide the perfect-scrollbar when collapsed -->
        <perfect-scrollbar
          v-if="!store.sidebar"
          :options="{ swipeEasing: true, wheelPropagation: false }"
          class="h-[calc(100vh-80px)] relative"
        >
            <ul class="relative font-semibold space-y-0.5 p-4 py-0">
              <!-- Dashboard Menu -->
              <li class="menu nav-item">
                <button
                  type="button"
                  class="nav-link group w-full"
                  :class="{ active: activeDropdowns['dashboard'] }"
                  @click="toggleDropdown('dashboard')"
                >
                  <div class="flex items-center">
                    <IconMenuDashboard class="group-hover:!text-primary shrink-0" />
                    <span
                      class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                      {{ translate('dashboard') }}
                    </span>
                  </div>
                  <div
                    :class="{
                      'rtl:rotate-90 -rotate-90': !activeDropdowns['dashboard'],
                    }"
                  >
                    <IconCaretDown />
                  </div>
                </button>
                <VueCollapsible :isOpen="activeDropdowns['dashboard']">
                  <ul class="sub-menu text-gray-500">
                    <li>
                      <router-link to="/" @click="toggleMobileMenu">
                        {{ translate('sales') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/analytics" @click="toggleMobileMenu">
                        {{ translate('analytics') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/finance" @click="toggleMobileMenu">
                        {{ translate('finance') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/crypto" @click="toggleMobileMenu">
                        {{ translate('crypto') }}
                      </router-link>
                    </li>
                  </ul>
                </VueCollapsible>
              </li>
  
              <!-- Apps Header -->
              <h2
                class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1"
              >
                <IconMinus class="w-4 h-5 flex-none hidden" />
                <span>{{ translate('apps') }}</span>
              </h2>
  
              <!-- Chat App -->
              <li class="nav-item">
                <router-link
                  to="/apps/chat"
                  class="group"
                  @click="toggleMobileMenu"
                >
                  <div class="flex items-center">
                    <IconMenuChat class="group-hover:!text-primary shrink-0" />
                    <span
                      class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                      {{ translate('chat') }}
                    </span>
                  </div>
                </router-link>
              </li>
  
              <!-- Mailbox App -->
              <li class="nav-item">
                <router-link
                  to="/apps/mailbox"
                  class="group"
                  @click="toggleMobileMenu"
                >
                  <div class="flex items-center">
                    <IconMenuMailbox class="group-hover:!text-primary shrink-0" />
                    <span
                      class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                      {{ translate('mailbox') }}
                    </span>
                  </div>
                </router-link>
              </li>
  
              <!-- Additional Apps -->
              <!-- Repeat similar structure for other apps like Todo List, Notes, Scrumboard, etc. -->
              <!-- Additional Apps -->

                <!-- Todo List App -->
              <li class="nav-item">
                <router-link
                    to="/apps/todolist"
                    class="group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuTodo class="group-hover:!text-primary shrink-0" />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('todo_list') }}
                    </span>
                    </div>
                </router-link>
              </li>

                <!-- Notes App -->
              <li class="nav-item">
                <router-link
                    to="/apps/notes"
                    class="group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuNotes class="group-hover:!text-primary shrink-0" />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('notes') }}
                    </span>
                    </div>
                </router-link>
              </li>

                <!-- Scrumboard App -->
              <li class="nav-item">
                <router-link
                    to="/apps/scrumboard"
                    class="group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuScrumboard class="group-hover:!text-primary shrink-0" />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('scrumboard') }}
                    </span>
                    </div>
                </router-link>
              </li>

                <!-- Contacts App -->
              <li class="nav-item">
                <router-link
                    to="/apps/contacts"
                    class="group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuContacts class="group-hover:!text-primary shrink-0" />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('contacts') }}
                    </span>
                    </div>
                </router-link>
              </li>

                <!-- Invoice Menu -->
                <li class="menu nav-item">
                <button
                  type="button"
                  class="nav-link group w-full"
                  :class="{ active: activeDropdowns.invoice }"
                  @click="toggleDropdown('invoice')"
                >
                  <div class="flex items-center">
                    <IconMenuInvoice class="group-hover:!text-primary shrink-0" />
                    <span
                      class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                      {{ translate('invoice') }}
                    </span>
                  </div>
                  <div
                    :class="{ 'rtl:rotate-90 -rotate-90': !activeDropdowns.invoice }"
                  >
                    <IconCaretDown />
                  </div>
                </button>
                <VueCollapsible :isOpen="activeDropdowns.invoice">
                  <ul class="sub-menu text-gray-500">
                    <li>
                      <router-link to="/apps/invoice/list" @click="toggleMobileMenu">
                        {{ translate('list') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/apps/invoice/preview" @click="toggleMobileMenu">
                        {{ translate('preview') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/apps/invoice/add" @click="toggleMobileMenu">
                        {{ translate('add') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/apps/invoice/edit" @click="toggleMobileMenu">
                        {{ translate('edit') }}
                      </router-link>
                    </li>
                  </ul>
                </VueCollapsible>
              </li>


                <!-- Calendar App -->
              <li class="nav-item">
                <router-link
                    to="/apps/calendar"
                    class="group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuCalendar class="group-hover:!text-primary shrink-0" />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('calendar') }}
                    </span>
                    </div>
                </router-link>
              </li>
              <!-- Components Header -->
              <h2
                class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1"
              >
                <IconMinus class="w-4 h-5 flex-none hidden" />
                <span>{{ translate('user_interface') }}</span>
              </h2>
  
              <li class="menu nav-item">
              <button
                type="button"
                class="nav-link group w-full"
                :class="{ active: activeDropdowns.components }"
                @click="toggleDropdown('components')"
              >
                <div class="flex items-center">
                  <IconMenuComponents class="group-hover:!text-primary shrink-0" />
                  <span
                    class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                  >
                    {{ translate('components') }}
                  </span>
                </div>
                <div :class="{ 'rtl:rotate-90 -rotate-90': !activeDropdowns.components }">
                  <IconCaretDown />
                </div>
              </button>
              <VueCollapsible :isOpen="activeDropdowns.components">
                <ul class="sub-menu text-gray-500">
                  <li>
                    <router-link to="/components/tabs" @click="toggleMobileMenu">
                      {{ translate('tabs') }}
                    </router-link>
                  </li>
                  <li>
                    <router-link to="/components/accordions" @click="toggleMobileMenu">
                      {{ translate('accordions') }}
                    </router-link>
                  </li>
                  <li>
                    <router-link to="/components/modals" @click="toggleMobileMenu">
                      {{ translate('modals') }}
                    </router-link>
                  </li>
                </ul>
              </VueCollapsible>
            </li>

  
              <!-- Elements Menu -->
              <!-- Similar structure for Elements Menu -->
              <!-- Elements Menu -->
              <li class="menu nav-item">
                <button
                  type="button"
                  class="nav-link group w-full"
                  :class="{ active: activeDropdowns.elements }"
                  @click="toggleDropdown('elements')"
                >
                  <div class="flex items-center">
                    <IconMenuElements class="group-hover:!text-primary shrink-0" />
                    <span
                      class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                      {{ translate('elements') }}
                    </span>
                  </div>
                  <div :class="{ 'rtl:rotate-90 -rotate-90': !activeDropdowns.elements }">
                    <IconCaretDown />
                  </div>
                </button>
                <VueCollapsible :isOpen="activeDropdowns.elements">
                  <ul class="sub-menu text-gray-500">
                    <li>
                      <router-link to="/elements/alerts" @click="toggleMobileMenu">
                        {{ translate('alerts') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/elements/avatar" @click="toggleMobileMenu">
                        {{ translate('avatar') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/elements/badges" @click="toggleMobileMenu">
                        {{ translate('badges') }}
                      </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/breadcrumbs" @click="toggleMobileMenu">
                        {{ translate('breadcrumbs') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/buttons" @click="toggleMobileMenu">
                        {{ translate('buttons') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/buttons-group" @click="toggleMobileMenu">
                        {{ translate('button_groups') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/color-library" @click="toggleMobileMenu">
                        {{ translate('color_library') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/dropdown" @click="toggleMobileMenu">
                        {{ translate('dropdown') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/infobox" @click="toggleMobileMenu">
                        {{ translate('infobox') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/jumbotron" @click="toggleMobileMenu">
                        {{ translate('jumbotron') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/loader" @click="toggleMobileMenu">
                        {{ translate('loader') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/pagination" @click="toggleMobileMenu">
                        {{ translate('pagination') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/popovers" @click="toggleMobileMenu">
                        {{ translate('popovers') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/progress-bar" @click="toggleMobileMenu">
                        {{ translate('progress_bar') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/search" @click="toggleMobileMenu">
                        {{ translate('search') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/tooltips" @click="toggleMobileMenu">
                        {{ translate('tooltips') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/treeview" @click="toggleMobileMenu">
                        {{ translate('treeview') }}
                        </router-link>
                    </li>
                    <li>
                        <router-link to="/elements/typography" @click="toggleMobileMenu">
                        {{ translate('typography') }}
                        </router-link>
                    </li>
                    </ul>
                </VueCollapsible>
                </li>

              <!-- Additional Menus -->
              <!-- Repeat similar structures for Charts, Widgets, Font Icons, etc. -->
              <!-- Charts Menu -->
                <li class="menu nav-item">
                <router-link
                    to="/charts"
                    class="nav-link group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuCharts class="group-hover:!text-primary shrink-0" />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('charts') }}
                    </span>
                    </div>
                </router-link>
                </li>

                <!-- Widgets Menu -->
                <li class="menu nav-item">
                <router-link
                    to="/widgets"
                    class="nav-link group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuWidgets class="group-hover:!text-primary shrink-0" />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('widgets') }}
                    </span>
                    </div>
                </router-link>
                </li>

                <!-- Font Icons Menu -->
                <li class="menu nav-item">
                <router-link
                    to="/font-icons"
                    class="nav-link group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuFontIcons class="group-hover:!text-primary shrink-0" />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('font_icons') }}
                    </span>
                    </div>
                </router-link>
                </li>

                <!-- Drag and Drop Menu -->
                <li class="menu nav-item">
                <router-link
                    to="/dragndrop"
                    class="nav-link group"
                    @click="toggleMobileMenu"
                >
                    <div class="flex items-center">
                    <IconMenuDragAndDrop
                        class="group-hover:!text-primary shrink-0"
                    />
                    <span
                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                        {{ translate('drag_and_drop') }}
                    </span>
                    </div>
                </router-link>
                </li>

              <!-- Tables and Forms Header -->
              <h2
                class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1"
              >
                <IconMinus class="w-4 h-5 flex-none hidden" />
                <span>{{ translate('tables_and_forms') }}</span>
              </h2>
  
              <!-- Tables Menu -->
              <li class="menu nav-item">
                <router-link
                  to="/tables"
                  class="nav-link group"
                  @click="toggleMobileMenu"
                >
                  <div class="flex items-center">
                    <IconMenuTables class="group-hover:!text-primary shrink-0" />
                    <span
                      class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                      {{ translate('tables') }}
                    </span>
                  </div>
                </router-link>
              </li>
  
              <!-- Forms Menu -->
              <!-- Similar structure for Forms Menu -->
              <!-- Forms Menu -->
              <li class="menu nav-item">
              <button
                type="button"
                class="nav-link group w-full"
                :class="{ active: activeDropdowns.forms }"
                @click="toggleDropdown('forms')"
              >
                <div class="flex items-center">
                  <IconMenuForms class="group-hover:!text-primary shrink-0" />
                  <span
                    class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                  >
                    {{ translate('forms') }}
                  </span>
                </div>
                <div :class="{ 'rtl:rotate-90 -rotate-90': !activeDropdowns.forms }">
                  <IconCaretDown />
                </div>
              </button>
              <VueCollapsible :isOpen="activeDropdowns.forms">
                <ul class="sub-menu text-gray-500">
                  <li>
                    <router-link to="/forms/basic" @click="toggleMobileMenu">
                      {{ translate('basic') }}
                    </router-link>
                  </li>
                    <li>
                      <router-link to="/forms/input-group" @click="toggleMobileMenu">
                        {{ translate('input_group') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/layouts" @click="toggleMobileMenu">
                        {{ translate('layouts') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/validation" @click="toggleMobileMenu">
                        {{ translate('validation') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/input-mask" @click="toggleMobileMenu">
                        {{ translate('input_mask') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/select2" @click="toggleMobileMenu">
                        {{ translate('select2') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/touchspin" @click="toggleMobileMenu">
                        {{ translate('touchspin') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/checkbox-radio" @click="toggleMobileMenu">
                        {{ translate('checkbox_and_radio') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/switches" @click="toggleMobileMenu">
                        {{ translate('switches') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/wizards" @click="toggleMobileMenu">
                        {{ translate('wizards') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/file-upload" @click="toggleMobileMenu">
                        {{ translate('file_upload') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/quill-editor" @click="toggleMobileMenu">
                        {{ translate('quill_editor') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/markdown-editor" @click="toggleMobileMenu">
                        {{ translate('markdown_editor') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/date-picker" @click="toggleMobileMenu">
                        {{ translate('date_and_range_picker') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/forms/clipboard" @click="toggleMobileMenu">
                        {{ translate('clipboard') }}
                      </router-link>
                    </li>
                  </ul>
                </VueCollapsible>
              </li>

              <!-- Users and Pages Header -->
              <h2
                class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1"
              >
                <IconMinus class="w-4 h-5 flex-none hidden" />
                <span>{{ translate('user_and_pages') }}</span>
              </h2>
  
              <!-- Users Menu -->
              <li class="menu nav-item">
              <button
                type="button"
                class="nav-link group w-full"
                :class="{ active: activeDropdowns['users'] }"
                @click="toggleDropdown('users')"
              >
                <div class="flex items-center">
                  <IconMenuUsers class="group-hover:!text-primary shrink-0" />
                  <span
                    class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                  >
                    {{ translate('users') }}
                  </span>
                </div>
                <div
                  :class="{
                    'rtl:rotate-90 -rotate-90': !activeDropdowns['users'],
                  }"
                >
                  <IconCaretDown />
                </div>
              </button>
              <VueCollapsible :isOpen="activeDropdowns['users']">
                <ul class="sub-menu text-gray-500">
                  <li>
                    <router-link to="/users/profile" @click="toggleMobileMenu">
                      {{ translate('profile') }}
                    </router-link>
                  </li>
                  <li>
                    <router-link to="/users/user-account-settings" @click="toggleMobileMenu">
                      {{ translate('account_settings') }}
                    </router-link>
                  </li>
                </ul>
              </VueCollapsible>
            </li>
  
              <!-- Pages Menu -->
              <!-- Similar structure for Pages Menu -->
                <!-- Pages Menu -->
                <li class="menu nav-item">
                <button
                  type="button"
                  class="nav-link group w-full"
                  :class="{ active: activeDropdowns['pages'] }"
                  @click="toggleDropdown('pages')"
                >
                  <div class="flex items-center">
                    <IconMenuPages class="group-hover:!text-primary shrink-0" />
                    <span
                      class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                      {{ translate('pages') }}
                    </span>
                  </div>
                  <div
                    :class="{
                      'rtl:rotate-90 -rotate-90': !activeDropdowns['pages'],
                    }"
                  >
                    <IconCaretDown />
                  </div>
                </button>
                <VueCollapsible :isOpen="activeDropdowns['pages']">
                  <ul class="sub-menu text-gray-500">
                    <li>
                      <router-link to="/pages/knowledge-base" @click="toggleMobileMenu">
                        {{ translate('knowledge_base') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/pages/contact-us-boxed" target="_blank" @click="toggleMobileMenu">
                        {{ translate('contact_us_boxed') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/pages/contact-us-cover" target="_blank" @click="toggleMobileMenu">
                        {{ translate('contact_us_cover') }}
                      </router-link>
                    </li>
                    <li @click="toggleMobileMenu">
                      <router-link to="/pages/contact-us-boxed" target="_blank">
                        {{ translate('contact_us_boxed') }}
                      </router-link>
                    </li>
                    <li @click="toggleMobileMenu">
                      <router-link to="/pages/contact-us-cover" target="_blank">
                        {{ translate('contact_us_cover') }}
                      </router-link>
                    </li>
                    <li>
                      <router-link to="/pages/faq" @click="toggleMobileMenu">
                        {{ translate('faq') }}
                      </router-link>
                    </li>
                    <li @click="toggleMobileMenu">
                      <router-link to="/pages/coming-soon-boxed" target="_blank">
                        {{ translate('coming_soon_boxed') }}
                      </router-link>
                    </li>
                    <li @click="toggleMobileMenu">
                      <router-link to="/pages/coming-soon-cover" target="_blank">
                        {{ translate('coming_soon_cover') }}
                      </router-link>
                    </li>
                    <!-- Error Pages Submenu -->
                    <li class="menu nav-item">
                      <button
                        type="button"
                        class="w-full before:bg-gray-300 before:w-[5px] before:h-[5px] before:rounded ltr:before:mr-2 rtl:before:ml-2 dark:text-[#888ea8] hover:bg-gray-100 dark:hover:bg-gray-900"
                        @click="
                          subActive === 'error'
                            ? (subActive = null)
                            : (subActive = 'error')
                        "
                      >
                        {{ translate('error') }}
                        <div
                          class="ltr:ml-auto rtl:mr-auto"
                          :class="{ 'rtl:rotate-90 -rotate-90': subActive !== 'error' }"
                        >
                          <IconCaretsDown :fill="true" class="w-4 h-4" />
                        </div>
                      </button>
                      <VueCollapsible :isOpen="subActive === 'error'">
                        <ul class="sub-menu text-gray-500">
                          <li @click="toggleMobileMenu">
                            <router-link to="/pages/error404" target="_blank">
                              {{ translate('404') }}
                            </router-link>
                          </li>
                          <li @click="toggleMobileMenu">
                            <router-link to="/pages/error500" target="_blank">
                              {{ translate('500') }}
                            </router-link>
                          </li>
                          <li @click="toggleMobileMenu">
                            <router-link to="/pages/error503" target="_blank">
                              {{ translate('503') }}
                            </router-link>
                          </li>
                        </ul>
                      </VueCollapsible>
                    </li>
                    <li>
                      <router-link to="/pages/maintenence" target="_blank">
                        {{ translate('maintenence') }}
                      </router-link>
                    </li>
                  </ul>
                </VueCollapsible>
              </li>

              <!-- Supports Header -->
              <h2
                class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1"
              >
                <IconMinus class="w-4 h-5 flex-none hidden" />
                <span>{{ translate('supports') }}</span>
              </h2>
  
              <!-- Documentation Link -->
              <li class="menu nav-item">
                <a
                  href="https://vristo.sbthemes.com"
                  target="_blank"
                  class="nav-link group"
                >
                  <div class="flex items-center">
                    <IconMenuDocumentation
                      class="group-hover:!text-primary shrink-0"
                    />
                    <span
                      class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark"
                    >
                      {{ translate('documentation') }}
                    </span>
                  </div>
                </a>
              </li>
            </ul>
          </perfect-scrollbar>
        </div>
      </nav>
    </div>
  </template>
  
  <script lang="ts" setup>

defineProps({
            translate: {
                type: Function,
                required: true,
            },
        });

  import { ref, onMounted, watch } from 'vue';
  import { useAppStore } from '@/stores/index';

  import VueCollapsible from 'vue-height-collapsible/vue3';
  
  import IconCaretsDown from '@/Components/icon/icon-carets-down.vue';
  import IconMenuDashboard from '@/Components/icon/menu/icon-menu-dashboard.vue';
  import IconMinus from '@/Components/icon/icon-minus.vue';
  import IconMenuChat from '@/Components/icon/menu/icon-menu-chat.vue';
  import IconMenuMailbox from '@/Components/icon/menu/icon-menu-mailbox.vue';
  import IconMenuTodo from '@/Components/icon/menu/icon-menu-todo.vue';
  import IconMenuNotes from '@/Components/icon/menu/icon-menu-notes.vue';
  import IconMenuScrumboard from '@/Components/icon/menu/icon-menu-scrumboard.vue';
  import IconMenuContacts from '@/Components/icon/menu/icon-menu-contacts.vue';
  import IconMenuInvoice from '@/Components/icon/menu/icon-menu-invoice.vue';
  import IconCaretDown from '@/Components/icon/icon-caret-down.vue';
  import IconMenuCalendar from '@/Components/icon/menu/icon-menu-calendar.vue';
  import IconMenuComponents from '@/Components/icon/menu/icon-menu-components.vue';
  import IconMenuElements from '@/Components/icon/menu/icon-menu-elements.vue';
  import IconMenuCharts from '@/Components/icon/menu/icon-menu-charts.vue';
  import IconMenuWidgets from '@/Components/icon/menu/icon-menu-widgets.vue';
  import IconMenuFontIcons from '@/Components/icon/menu/icon-menu-font-icons.vue';
  import IconMenuDragAndDrop from '@/Components/icon/menu/icon-menu-drag-and-drop.vue';
  import IconMenuTables from '@/Components/icon/menu/icon-menu-tables.vue';
  import IconMenuDatatables from '@/Components/icon/menu/icon-menu-datatables.vue';
  import IconMenuForms from '@/Components/icon/menu/icon-menu-forms.vue';
  import IconMenuUsers from '@/Components/icon/menu/icon-menu-users.vue';
  import IconMenuPages from '@/Components/icon/menu/icon-menu-pages.vue';
  import IconMenuAuthentication from '@/Components/icon/menu/icon-menu-authentication.vue';
  import IconMenuDocumentation from '@/Components/icon/menu/icon-menu-documentation.vue';
  
  const store = useAppStore();
  const activeDropdowns = ref<{ [key: string]: boolean }>({}); // Tracks the open/closed state of each dropdown


  const subActive = ref<string | null>(null);
  
  const toggleMobileMenu = () => {
  if (window.innerWidth < 1024) {
    store.toggleSidebar();
  }
};

const toggleSidebar = () => {
  store.toggleSidebar(); // Toggle the sidebar state (collapsed or expanded)
  if (store.sidebar) {
    activeDropdowns.value = {}; // Reset all open submenus if the sidebar is collapsed
  }
};

const toggleDropdown = (menu: string) => {
  activeDropdowns.value[menu] = !activeDropdowns.value[menu]; // Toggle the dropdown state for the given menu
};

// Initialize the state on mounted
onMounted(() => {
  // Initialize all dropdowns to false on mount (ensure they are closed)
  activeDropdowns.value = {
    dashboard: false,
    invoice: false,
    components: false,
    elements: false,
    forms: false,
    users: false,
    pages: false,
    // Add other dropdowns here as needed
  };

  // Handle the active route highlighting without opening dropdowns
  const selector = document.querySelector(
    '.sidebar ul a[href="' + window.location.pathname + '"]'
  ) as HTMLElement;

  if (selector) {
    selector.classList.add('active');
    const ul = selector.closest('ul.sub-menu');
    if (ul) {
      const menuItem = ul.closest('li.menu');
      if (menuItem) {
        const navLink = menuItem.querySelector('.nav-link') as HTMLElement;
        if (navLink) {
          navLink.classList.add('active');
        }
      }
    }
  }
});

watch(
  () => store.sidebar,
  (newSidebarState) => {
    if (newSidebarState) {
      activeDropdowns.value = {}; // Collapse all submenus when the sidebar is collapsed
    }
  }
);
</script>
  
  <style scoped>
  /* Add any additional styles here */
  </style>
  