import React from 'react';
import {
  Search,
  Bell,
  Settings,
  Moon,
  Sun,
  Globe,
  ChevronDown
} from 'lucide-react';
import { useTheme } from '../../contexts/ThemeContext';
import { useAuth } from '../../contexts/AuthContext';

const Header: React.FC = () => {
  const { theme, language, toggleTheme, toggleLanguage } = useTheme();
  const { user } = useAuth();

  return (
    <header className="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-700 px-6 py-4">
      <div className="flex items-center justify-between">
        {/* Search Bar */}
        <div className="flex-1 max-w-lg">
          <div className="relative">
            <Search className="absolute start-3 top-1/2 transform -translate-y-1/2 text-gray-400 w-5 h-5" />
            <input
              type="text"
              placeholder={language === 'ar' ? 'البحث في النظام...' : 'Search in system...'}
              className="w-full bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg ps-10 pe-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent"
            />
          </div>
        </div>

        {/* Right Side Actions */}
        <div className="flex items-center space-x-4 rtl:space-x-reverse">
          {/* Theme Toggle */}
          <button
            onClick={toggleTheme}
            className="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
            title={theme === 'light' ? (language === 'ar' ? 'الوضع المظلم' : 'Dark Mode') : (language === 'ar' ? 'الوضع المضيء' : 'Light Mode')}
          >
            {theme === 'light' ? <Moon className="w-5 h-5" /> : <Sun className="w-5 h-5" />}
          </button>

          {/* Language Toggle */}
          <button
            onClick={toggleLanguage}
            className="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors"
            title={language === 'ar' ? 'English' : 'العربية'}
          >
            <Globe className="w-5 h-5" />
          </button>

          {/* Notifications */}
          <div className="relative">
            <button className="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
              <Bell className="w-5 h-5" />
              {/* Notification Badge */}
              <span className="absolute -top-1 -end-1 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center">
                3
              </span>
            </button>
          </div>

          {/* Settings */}
          <button className="p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
            <Settings className="w-5 h-5" />
          </button>

          {/* User Menu */}
          <div className="relative">
            <button className="flex items-center space-x-3 rtl:space-x-reverse p-2 text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
              <div className="w-8 h-8 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
                <span className="text-gray-700 dark:text-gray-300 font-semibold text-sm">
                  {user?.name?.charAt(0) || 'A'}
                </span>
              </div>
              <div className="hidden md:block text-start">
                <p className="text-sm font-medium text-gray-900 dark:text-white truncate">
                  {user?.name}
                </p>
                <p className="text-xs text-gray-500 dark:text-gray-400">
                  {user?.role === 'admin' ? (language === 'ar' ? 'مدير' : 'Admin') : user?.role}
                </p>
              </div>
              <ChevronDown className="w-4 h-4 text-gray-400" />
            </button>
          </div>
        </div>
      </div>

      {/* Quick Stats Bar */}
      <div className="mt-4 flex items-center justify-between">
        <div className="flex items-center space-x-6 rtl:space-x-reverse">
          <div className="text-center">
            <div className="text-2xl font-bold text-gray-900 dark:text-white">1,234</div>
            <div className="text-xs text-gray-500 dark:text-gray-400">
              {language === 'ar' ? 'العملاء' : 'Customers'}
            </div>
          </div>
          <div className="text-center">
            <div className="text-2xl font-bold text-green-600">567</div>
            <div className="text-xs text-gray-500 dark:text-gray-400">
              {language === 'ar' ? 'الرسائل اليوم' : 'Messages Today'}
            </div>
          </div>
          <div className="text-center">
            <div className="text-2xl font-bold text-blue-600">89%</div>
            <div className="text-xs text-gray-500 dark:text-gray-400">
              {language === 'ar' ? 'معدل الاستجابة' : 'Response Rate'}
            </div>
          </div>
        </div>

        <div className="text-sm text-gray-500 dark:text-gray-400">
          {language === 'ar' ? 'آخر تحديث: الآن' : 'Last updated: Now'}
        </div>
      </div>
    </header>
  );
};

export default Header;