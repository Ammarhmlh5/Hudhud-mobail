import React from 'react';
import { NavLink, useLocation } from 'react-router-dom';
import {
  Home,
  Users,
  MessageSquare,
  BarChart3,
  Building,
  UserCheck,
  Settings,
  LogOut,
  Brain,
  Bell,
  Shield
} from 'lucide-react';
import { useAuth } from '../../contexts/AuthContext';
import { useTheme } from '../../contexts/ThemeContext';

const Sidebar: React.FC = () => {
  const { user, logout } = useAuth();
  const { language } = useTheme();
  const location = useLocation();

  const navigationItems = [
    {
      id: 'dashboard',
      label: language === 'ar' ? 'لوحة التحكم' : 'Dashboard',
      icon: Home,
      path: '/dashboard'
    },
    {
      id: 'customers',
      label: language === 'ar' ? 'إدارة العملاء' : 'Customer Management',
      icon: Users,
      path: '/customers'
    },
    {
      id: 'messages',
      label: language === 'ar' ? 'نظام الرسائل' : 'Messaging System',
      icon: MessageSquare,
      path: '/messages'
    },
    {
      id: 'analytics',
      label: language === 'ar' ? 'التقارير والإحصائيات' : 'Reports & Analytics',
      icon: BarChart3,
      path: '/analytics'
    },
    {
      id: 'company',
      label: language === 'ar' ? 'إدارة الشركة' : 'Company Management',
      icon: Building,
      path: '/company'
    },
    {
      id: 'team',
      label: language === 'ar' ? 'إدارة الفريق' : 'Team Management',
      icon: UserCheck,
      path: '/team'
    }
  ];

  const advancedFeatures = [
    {
      id: 'ai',
      label: language === 'ar' ? 'الذكاء الاصطناعي' : 'AI Features',
      icon: Brain,
      path: '/ai'
    },
    {
      id: 'notifications',
      label: language === 'ar' ? 'التنبيهات الذكية' : 'Smart Notifications',
      icon: Bell,
      path: '/notifications'
    },
    {
      id: 'security',
      label: language === 'ar' ? 'الأمان المتقدم' : 'Advanced Security',
      icon: Shield,
      path: '/security'
    }
  ];

  const isActive = (path: string) => location.pathname === path;

  return (
    <div className="bg-white dark:bg-gray-900 border-e border-gray-200 dark:border-gray-700 w-64 min-h-screen flex flex-col">
      {/* Logo and Brand */}
      <div className="p-6 border-b border-gray-200 dark:border-gray-700">
        <div className="flex items-center space-x-3 rtl:space-x-reverse">
          <div className="w-10 h-10 bg-primary-600 rounded-lg flex items-center justify-center">
            <span className="text-white font-bold text-lg">ح</span>
          </div>
          <div>
            <h1 className="text-xl font-bold text-gray-900 dark:text-white font-arabic">
              هدهد
            </h1>
            <p className="text-sm text-gray-500 dark:text-gray-400">
              {language === 'ar' ? 'نظام إدارة علاقات العملاء' : 'CRM System'}
            </p>
          </div>
        </div>
      </div>

      {/* User Info */}
      <div className="p-4 border-b border-gray-200 dark:border-gray-700">
        <div className="flex items-center space-x-3 rtl:space-x-reverse">
          <div className="w-10 h-10 bg-gray-300 dark:bg-gray-600 rounded-full flex items-center justify-center">
            <span className="text-gray-700 dark:text-gray-300 font-semibold">
              {user?.name?.charAt(0) || 'A'}
            </span>
          </div>
          <div className="flex-1 min-w-0">
            <p className="text-sm font-medium text-gray-900 dark:text-white truncate">
              {user?.name}
            </p>
            <p className="text-xs text-gray-500 dark:text-gray-400 truncate">
              {user?.role === 'admin' ? (language === 'ar' ? 'مدير' : 'Admin') : user?.role}
            </p>
          </div>
        </div>
      </div>

      {/* Navigation */}
      <nav className="flex-1 py-4">
        <div className="px-3">
          <p className="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">
            {language === 'ar' ? 'القائمة الرئيسية' : 'Main Menu'}
          </p>
        </div>
        <ul className="space-y-1 px-3">
          {navigationItems.map((item) => {
            const Icon = item.icon;
            return (
              <li key={item.id}>
                <NavLink
                  to={item.path}
                  className={`flex items-center space-x-3 rtl:space-x-reverse px-3 py-2 rounded-lg text-sm font-medium transition-colors ${
                    isActive(item.path)
                      ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300'
                      : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                  }`}
                >
                  <Icon className="w-5 h-5" />
                  <span>{item.label}</span>
                </NavLink>
              </li>
            );
          })}
        </ul>

        {/* Advanced Features */}
        <div className="px-3 mt-8">
          <p className="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider mb-3">
            {language === 'ar' ? 'الميزات المتقدمة' : 'Advanced Features'}
          </p>
        </div>
        <ul className="space-y-1 px-3">
          {advancedFeatures.map((item) => {
            const Icon = item.icon;
            return (
              <li key={item.id}>
                <NavLink
                  to={item.path}
                  className={`flex items-center space-x-3 rtl:space-x-reverse px-3 py-2 rounded-lg text-sm font-medium transition-colors ${
                    isActive(item.path)
                      ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300'
                      : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
                  }`}
                >
                  <Icon className="w-5 h-5" />
                  <span>{item.label}</span>
                </NavLink>
              </li>
            );
          })}
        </ul>
      </nav>

      {/* Settings and Logout */}
      <div className="p-3 border-t border-gray-200 dark:border-gray-700">
        <NavLink
          to="/settings"
          className={`flex items-center space-x-3 rtl:space-x-reverse px-3 py-2 rounded-lg text-sm font-medium transition-colors mb-2 ${
            isActive('/settings')
              ? 'bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300'
              : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800'
          }`}
        >
          <Settings className="w-5 h-5" />
          <span>{language === 'ar' ? 'الإعدادات' : 'Settings'}</span>
        </NavLink>
        
        <button
          onClick={logout}
          className="w-full flex items-center space-x-3 rtl:space-x-reverse px-3 py-2 rounded-lg text-sm font-medium text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition-colors"
        >
          <LogOut className="w-5 h-5" />
          <span>{language === 'ar' ? 'تسجيل الخروج' : 'Logout'}</span>
        </button>
      </div>
    </div>
  );
};

export default Sidebar;