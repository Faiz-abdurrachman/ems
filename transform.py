import os
import re

def process_file(filepath):
    with open(filepath, 'r') as f:
        content = f.read()

    # Cards and boxes
    content = re.sub(r'rounded-xl border border-gray-200 bg-white shadow-sm', 
                     r'rounded-xl border-4 border-black bg-white shadow-[8px_8px_0_0_#1A1A1A] transition-transform hover:-translate-y-1 hover:translate-x-1 hover:shadow-[12px_12px_0_0_#1A1A1A]', content)
    
    # Dashboard summary cards
    content = re.sub(r'rounded-xl bg-white p-6 shadow-sm border border-gray-200',
                     r'rounded-xl bg-white p-6 border-4 border-black shadow-[8px_8px_0_0_#1A1A1A] transition-transform hover:-translate-y-1 hover:translate-x-1 hover:shadow-[12px_12px_0_0_#1A1A1A]', content)
                     
    # Primary Buttons
    content = re.sub(r'bg-indigo-600([^"]*)text-white([^"]*)hover:bg-indigo-500', 
                     r'bg-[#22D3EE] \1text-black\2hover:bg-[#22D3EE] border-2 border-black shadow-[4px_4px_0_0_#1A1A1A] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[2px_2px_0_0_#1A1A1A] transition-all font-bold', content)
                     
    # Secondary / Default Buttons
    content = re.sub(r'bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50',
                     r'bg-white px-4 py-2 text-sm font-bold text-black border-2 border-black shadow-[4px_4px_0_0_#1A1A1A] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[2px_2px_0_0_#1A1A1A] transition-all', content)
                     
    # Danger Buttons
    content = re.sub(r'bg-red-600([^"]*)text-white([^"]*)hover:bg-red-500',
                     r'bg-[#FF6B6B] \1text-black\2hover:bg-[#FF6B6B] border-2 border-black shadow-[4px_4px_0_0_#1A1A1A] hover:translate-x-[2px] hover:translate-y-[2px] hover:shadow-[2px_2px_0_0_#1A1A1A] transition-all font-bold', content)
    
    # Inputs
    content = re.sub(r'block w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500',
                     r'block w-full rounded-lg border-2 border-black shadow-[4px_4px_0_0_#1A1A1A] focus:border-black focus:ring-0 focus:translate-y-[2px] focus:translate-x-[2px] focus:shadow-[2px_2px_0_0_#1A1A1A] transition-all', content)

    # Tables
    content = re.sub(r'min-w-full divide-y divide-gray-200',
                     r'min-w-full divide-y-2 divide-black border-2 border-black shadow-[8px_8px_0_0_#1A1A1A] bg-white', content)
    content = re.sub(r'divide-y divide-gray-200', r'divide-y-2 divide-black', content)
    content = re.sub(r'bg-gray-50', r'bg-[#FFD700]', content) # Table headers and backgrounds

    # Text Colors
    content = re.sub(r'text-gray-900', r'text-black font-bold', content)
    content = re.sub(r'text-gray-500', r'text-gray-800 font-medium', content)
    
    # Status Badges
    content = re.sub(r'bg-blue-100 text-blue-700', r'bg-[#22D3EE] text-black border-2 border-black shadow-[2px_2px_0_0_#000] font-bold', content)
    content = re.sub(r'bg-emerald-100 text-emerald-700', r'bg-[#00D26A] text-black border-2 border-black shadow-[2px_2px_0_0_#000] font-bold', content)
    content = re.sub(r'bg-gray-100 text-gray-600', r'bg-white text-black border-2 border-black shadow-[2px_2px_0_0_#000] font-bold', content)
    content = re.sub(r'bg-red-100 text-red-700', r'bg-[#FF6B6B] text-black border-2 border-black shadow-[2px_2px_0_0_#000] font-bold', content)

    with open(filepath, 'w') as f:
        f.write(content)

for root, _, files in os.walk('resources/views'):
    for file in files:
        if file.endswith('.blade.php'):
            process_file(os.path.join(root, file))

